# 🔧 Backend Fixes Required

## Dokumentasi Perbaikan Backend Node.js API

**Tanggal:** 21 November 2025  
**Reporter:** Frontend Team (Admin Panel CodeIgniter)

---

## 1. ⚠️ CRITICAL: Biaya Admin Withdrawal Harus Flat Rp 2.500

### Masalah Saat Ini

Backend saat ini menghitung biaya admin withdrawal secara persentase/dinamis, seperti terlihat dari response API:

```json
{
  "id": 6,
  "jumlah": "180000",
  "biaya_admin": "7000",    // ❌ Tidak konsisten
  "jumlah_bersih": "173000"
}

{
  "id": 5,
  "jumlah": "350000",
  "biaya_admin": "11750",   // ❌ Tidak konsisten
  "jumlah_bersih": "338250"
}

{
  "id": 8,
  "jumlah": "350000",
  "biaya_admin": "5000",    // ❌ Tidak konsisten
  "jumlah_bersih": "345000"
}
```

### Yang Diharapkan

Biaya admin harus **FLAT Rp 2.500** untuk semua nominal penarikan:

```json
{
  "id": 6,
  "jumlah": "180000",
  "biaya_admin": "2500",    // ✅ FLAT
  "jumlah_bersih": "177500"
}

{
  "id": 5,
  "jumlah": "350000",
  "biaya_admin": "2500",    // ✅ FLAT
  "jumlah_bersih": "347500"
}
```

### Lokasi Perbaikan di Backend

**File:** `controllers/withdrawalController.js` atau `services/withdrawalService.js`

**Fungsi yang perlu diperbaiki:** `createWithdrawal()` atau sejenisnya

**Perubahan yang diperlukan:**

```javascript
// ❌ HAPUS kode ini (jika ada):
const biayaAdmin = Math.ceil(jumlah * 0.035); // 3.5% fee
// atau
const biayaAdmin = calculateAdminFee(jumlah);

// ✅ GANTI dengan ini:
const BIAYA_ADMIN_FLAT = 2500; // Rp 2.500 flat untuk semua penarikan
const biayaAdmin = BIAYA_ADMIN_FLAT;
const jumlahBersih = jumlah - biayaAdmin;
```

**Database Migration (jika perlu):**

```sql
-- Jika ada constraint atau default value yang salah
ALTER TABLE penarikan
  ALTER COLUMN biaya_admin SET DEFAULT 2500;

-- Update existing records (OPTIONAL - hati-hati!)
-- UPDATE penarikan
-- SET biaya_admin = 2500,
--     jumlah_bersih = jumlah - 2500
-- WHERE status = 'pending';
```

### Testing Setelah Fix

1. **Create new withdrawal request:**

   ```bash
   POST /api/tukang/withdrawal
   Body: { "jumlah": 100000, "nama_bank": "BCA", ... }
   ```

2. **Verify response:**

   ```json
   {
     "jumlah": "100000",
     "biaya_admin": "2500", // ✅ Must be 2500
     "jumlah_bersih": "97500" // ✅ Must be 100000 - 2500
   }
   ```

3. **Test various amounts:**
   - 50.000 → biaya_admin: 2500, bersih: 47500
   - 100.000 → biaya_admin: 2500, bersih: 97500
   - 500.000 → biaya_admin: 2500, bersih: 497500
   - 1.000.000 → biaya_admin: 2500, bersih: 997500

---

## 2. ℹ️ INFO: Withdrawal Flow Sudah Benar

### Current Backend Logic (CORRECT ✅)

Backend saat ini sudah implement logic yang benar:

**Saat Tukang Request Withdrawal:**

```javascript
// Step 1: Validate poin cukup
if (tukang.poin < jumlah) {
  return res.status(400).json({ message: "Poin tidak cukup" });
}

// Step 2: Potong poin LANGSUNG dari saldo tukang
await prisma.$transaction([
  prisma.users.update({
    where: { id: tukangId },
    data: { poin: { decrement: jumlah } }  // ✅ Poin dipotong di sini
  }),
  prisma.penarikan.create({
    data: { tukang_id: tukangId, jumlah, status: 'pending', ... }
  })
]);
```

**Saat Admin Confirm Withdrawal:**

```javascript
// Step 1: Upload bukti transfer
// Step 2: Update status jadi 'selesai'
// Step 3: TIDAK ada perubahan poin (sudah dipotong saat request) ✅

await prisma.penarikan.update({
  where: { id },
  data: {
    status: "selesai",
    bukti_transfer: filePath,
    diproses_oleh: adminId,
    waktu_diproses: new Date(),
  },
});
```

**Saat Admin Reject Withdrawal:**

```javascript
// Step 1: KEMBALIKAN poin ke tukang
await prisma.$transaction([
  prisma.users.update({
    where: { id: tukangId },
    data: { poin: { increment: jumlah } }, // ✅ Refund poin
  }),
  prisma.penarikan.update({
    where: { id },
    data: {
      status: "ditolak",
      alasan_penolakan,
      diproses_oleh: adminId,
      waktu_diproses: new Date(),
    },
  }),
]);
```

### Why This Design is Correct?

**Keuntungan:**

1. ✅ **Prevent Double Spending:** Poin langsung dipotong, tidak bisa dipakai untuk transaksi lain
2. ✅ **Audit Trail:** History withdrawal jelas dengan status pending/selesai/ditolak
3. ✅ **Atomic Transaction:** Menggunakan `prisma.$transaction` untuk data consistency
4. ✅ **Admin Responsibility:** Admin hanya approve/reject, tidak perlu kalkulasi manual

**Frontend Admin Panel hanya perlu:**

- Display data withdrawal pending
- Confirm dengan upload bukti transfer
- Reject dengan alasan penolakan

---

## 3. 📝 Additional Backend Improvements (OPTIONAL)

### A. Add Minimum Withdrawal Amount

```javascript
const MINIMUM_WITHDRAWAL = 50000; // Rp 50.000

if (jumlah < MINIMUM_WITHDRAWAL) {
  return res.status(400).json({
    status: "error",
    message: `Minimum penarikan adalah Rp ${MINIMUM_WITHDRAWAL.toLocaleString(
      "id-ID"
    )}`,
  });
}
```

### B. Add Maximum Withdrawal Amount (Daily/Monthly Limit)

```javascript
const MAXIMUM_WITHDRAWAL_DAILY = 5000000; // Rp 5 juta per hari

// Check daily withdrawal total
const todayWithdrawals = await prisma.penarikan.aggregate({
  where: {
    tukang_id: tukangId,
    created_at: {
      gte: new Date(new Date().setHours(0, 0, 0, 0)),
    },
    status: { in: ["pending", "selesai"] },
  },
  _sum: { jumlah: true },
});

if ((todayWithdrawals._sum.jumlah || 0) + jumlah > MAXIMUM_WITHDRAWAL_DAILY) {
  return res.status(400).json({
    status: "error",
    message: "Batas penarikan harian tercapai",
  });
}
```

### C. Add Notification System

```javascript
// Saat tukang request withdrawal
await sendNotificationToAdmin({
  type: "NEW_WITHDRAWAL_REQUEST",
  message: `${tukang.nama_lengkap} request penarikan Rp ${jumlah.toLocaleString(
    "id-ID"
  )}`,
  data: { withdrawal_id: newWithdrawal.id },
});

// Saat admin confirm
await sendNotificationToTukang({
  type: "WITHDRAWAL_CONFIRMED",
  message: `Penarikan Anda sebesar Rp ${jumlah.toLocaleString(
    "id-ID"
  )} telah diproses`,
  tukang_id: tukangId,
});

// Saat admin reject
await sendNotificationToTukang({
  type: "WITHDRAWAL_REJECTED",
  message: `Penarikan ditolak: ${alasan_penolakan}`,
  tukang_id: tukangId,
});
```

---

## 4. 🧪 Testing Checklist

### Before Deploy to Production

- [ ] **Test 1:** Create withdrawal dengan jumlah 100.000 → biaya_admin = 2500
- [ ] **Test 2:** Create withdrawal dengan jumlah 500.000 → biaya_admin = 2500
- [ ] **Test 3:** Verify poin langsung terpotong saat create withdrawal
- [ ] **Test 4:** Confirm withdrawal → poin tetap (tidak berubah)
- [ ] **Test 5:** Reject withdrawal → poin kembali ke saldo tukang
- [ ] **Test 6:** Try create withdrawal dengan poin tidak cukup → error 400
- [ ] **Test 7:** Verify jumlah_bersih = jumlah - 2500 (bukan persentase)

### Database Consistency Check

```sql
-- Cek apakah ada withdrawal dengan biaya_admin != 2500
SELECT id, jumlah, biaya_admin, jumlah_bersih, status, created_at
FROM penarikan
WHERE biaya_admin != 2500
ORDER BY created_at DESC;

-- Cek apakah formula jumlah_bersih benar
SELECT
  id,
  jumlah,
  biaya_admin,
  jumlah_bersih,
  (jumlah - biaya_admin) as expected_bersih,
  CASE
    WHEN jumlah_bersih = (jumlah - biaya_admin) THEN '✅ OK'
    ELSE '❌ WRONG'
  END as validation
FROM penarikan
WHERE status != 'dibatalkan'
ORDER BY created_at DESC
LIMIT 20;
```

---

## 5. 📞 Contact & Coordination

**Frontend Team (Admin Panel):**

- Platform: CodeIgniter 4
- Contact: frontend@rampungin.com

**Backend Team (API):**

- Platform: Node.js + Express + Prisma + PostgreSQL
- Contact: backend@rampungin.com

**Priority:** 🔴 HIGH (Critical business logic)

**Estimated Fix Time:** 30 minutes - 1 hour

---

## 6. 📋 Deployment Steps

1. **Update backend code** dengan biaya admin flat 2500
2. **Run database migration** (jika ada perubahan schema)
3. **Test di development environment** dengan semua test cases
4. **Deploy to staging** dan test dengan frontend admin panel
5. **Deploy to production** setelah UAT approved
6. **Monitor logs** untuk 24 jam pertama setelah deploy

---

**Status:** 🟡 PENDING BACKEND FIX  
**Last Updated:** 21 November 2025  
**Document Version:** 1.0

---

## Changelog

- **2025-11-21:** Initial document created
  - Identified biaya_admin inconsistency issue
  - Documented correct withdrawal flow
  - Added testing checklist and SQL verification queries
