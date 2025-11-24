# Perbaikan Data Mapping - Withdrawal & Monitor Transaksi

## Overview

Memperbaiki mapping data dari API response agar ditampilkan dengan benar di halaman withdrawal dan monitor transaksi sesuai struktur API yang sebenarnya.

---

## 1. Perbaikan Halaman Withdrawal

### Masalah

- Data "Diproses Oleh" tidak menampilkan nama admin dengan benar
- Tidak ada modal untuk melihat bukti transfer
- Struktur data API tidak sesuai dengan yang diharapkan view

### Solusi Implementasi

#### A. Update FinanceController.php

**File:** `app/Controllers/Admin/FinanceController.php`

**Perubahan:**

```php
// Menambahkan mapping untuk users_penarikan_diproses_olehTousers
'users_penarikan_diproses_olehTousers' => $item['users_penarikan_diproses_olehTousers']
```

**Struktur Data yang Dimapping:**

```json
{
  "users_penarikan_diproses_olehTousers": {
    "id": 1,
    "username": "admin",
    "nama_lengkap": "Super Administrator"
  }
}
```

#### B. Update withdrawal_list.php

**File:** `app/Views/admin/finance/withdrawal_list.php`

**Perubahan 1: Kolom "Diproses Oleh"**

- Menampilkan nama lengkap admin dari `users_penarikan_diproses_olehTousers`
- Menampilkan badge dengan ID admin
- Menampilkan waktu diproses jika ada

```php
<?php if (!empty($withdrawal['users_penarikan_diproses_olehTousers'])): ?>
    <small class="text-muted">
        <?= esc($withdrawal['users_penarikan_diproses_olehTousers']['nama_lengkap'] ?? 'Admin') ?><br>
        <span class="badge bg-secondary">ID: <?= esc($withdrawal['users_penarikan_diproses_olehTousers']['id']) ?></span><br>
        <?php if (!empty($withdrawal['waktu_diproses'])): ?>
            <?= date('d M Y H:i', strtotime($withdrawal['waktu_diproses'])) ?>
        <?php endif; ?>
    </small>
<?php else: ?>
    <span class="text-muted">-</span>
<?php endif; ?>
```

**Perubahan 2: Tambah Kolom "Bukti Transfer"**

- Menambahkan kolom baru di tabel header
- Tombol "Lihat Bukti" jika bukti_transfer ada
- Modal preview untuk bukti transfer (gambar atau PDF)

**Perubahan 3: Modal Bukti Transfer**

- Modal dengan ukuran large (`modal-lg`)
- Support preview gambar (JPG, PNG) dan PDF
- Informasi detail: Bank, No Rekening, Jumlah Transfer
- Tombol download untuk bukti transfer
- URL bukti: `{API_BASE_URL}/{bukti_transfer_path}`

```php
<?php
$buktiPath = $withdrawal['bukti_transfer'];
$apiUrl = getenv('API_BASE_URL') ?: 'http://localhost:3000';
$buktiUrl = $apiUrl . '/' . $buktiPath;
$isPdf = strtolower(pathinfo($buktiPath, PATHINFO_EXTENSION)) === 'pdf';
?>
```

**Perubahan 4: Update Colspan**

- Dari `colspan="10"` menjadi `colspan="11"` (tambah 1 kolom)

---

## 2. Perbaikan Halaman Monitor Transaksi

### Masalah

- Data client dan tukang tidak muncul (menggunakan key yang salah)
- Status filter tidak sesuai dengan API
- Metode pembayaran tidak sesuai dengan API (POIN vs poin)
- Pagination mapping tidak benar
- Rating tidak ditampilkan

### Solusi Implementasi

#### A. Update TransactionController.php

**File:** `app/Controllers/Admin/TransactionController.php`

**Perubahan: Pagination Mapping**

```php
// Dari API response format
{
  "page": 1,
  "limit": 20,
  "total": 523,
  "total_pages": 27
}

// Dimapping ke format view
[
  'current_page' => $pagination['page'] ?? 1,
  'total_pages' => $pagination['total_pages'] ?? 1,
  'total' => $pagination['total'] ?? 0,
  'per_page' => $pagination['limit'] ?? 20
]
```

#### B. Update index.php (Transaksi)

**File:** `app/Views/admin/transactions/index.php`

**Perubahan 1: Mapping Data Client & Tukang**

- **Sebelum:** `$trx['client']['nama_lengkap']` ❌
- **Sesudah:** `$trx['users_transaksi_client_idTousers']['nama_lengkap']` ✅

- **Sebelum:** `$trx['tukang']['nama_lengkap']` ❌
- **Sesudah:** `$trx['users_transaksi_tukang_idTousers']['nama_lengkap']` ✅

**Perubahan 2: Status Filter**

```php
// Nilai status yang benar dari API:
- pending
- diterima
- dalam_proses
- selesai
- ditolak
- dibatalkan
```

**Perubahan 3: Metode Pembayaran**

```php
// Nilai metode pembayaran yang benar dari API:
- POIN (uppercase)
- TUNAI (uppercase)

// Badge mapping:
$metodeBadge = [
    'POIN' => 'primary',
    'TUNAI' => 'success'
][$metode] ?? 'secondary';
```

**Perubahan 4: Simplifikasi Tabel**

- **Menghapus kolom:** Status, Rating (data tidak selalu ada)
- **Kolom yang tetap:** No Pesanan, Client, Tukang, Kategori, Judul Layanan, Lokasi, Total Biaya, Metode, Tanggal, Aksi
- **Total kolom:** 10 kolom

**Perubahan 5: Update DataTable Sort**

```javascript
// Dari: order: [[10, "desc"]] (kolom index 10)
// Ke: order: [[8, "desc"]] (kolom Tanggal sekarang di index 8)
```

**Perubahan 6: Tanggal Display**

- **Sebelum:** `$trx['tanggal_pesanan']` ❌
- **Sesudah:** `$trx['created_at']` ✅

---

## Testing Checklist

### Withdrawal Page

- [ ] Kolom "Diproses Oleh" menampilkan nama admin dengan benar
- [ ] Badge ID admin muncul
- [ ] Waktu diproses ditampilkan dengan format yang benar
- [ ] Tombol "Lihat Bukti" muncul untuk withdrawal yang sudah selesai
- [ ] Modal bukti transfer dapat dibuka
- [ ] Preview gambar bukti transfer ditampilkan dengan benar
- [ ] Preview PDF bukti transfer ditampilkan dengan benar
- [ ] Download bukti transfer berfungsi
- [ ] Untuk pending withdrawal, tampil "-" di kolom Diproses Oleh dan Bukti Transfer

### Monitor Transaksi Page

- [ ] Data client ditampilkan dengan nama lengkap dan username
- [ ] Data tukang ditampilkan dengan nama lengkap dan username
- [ ] Kategori ditampilkan dengan benar
- [ ] Total biaya diformat dengan Rupiah
- [ ] Metode pembayaran (POIN/TUNAI) ditampilkan dengan badge warna benar
- [ ] Tanggal transaksi ditampilkan dengan format yang benar
- [ ] Filter status berfungsi (pending, diterima, dalam_proses, selesai, ditolak, dibatalkan)
- [ ] Filter metode pembayaran berfungsi (POIN, TUNAI)
- [ ] Filter tanggal (start_date & end_date) berfungsi
- [ ] Pagination berfungsi dengan benar
- [ ] Tombol detail transaksi mengarah ke halaman yang benar
- [ ] DataTable sorting berfungsi (sort by tanggal descending)

---

## API Response Structure Reference

### Withdrawal API Response

```json
{
  "id": 5,
  "tukang_id": 11,
  "jumlah": "350000",
  "nama_bank": "BCA",
  "nomor_rekening": "7890123456",
  "nama_pemilik_rekening": "Eko Prasetyo",
  "biaya_admin": "11750",
  "jumlah_bersih": "338250",
  "status": "selesai",
  "diproses_oleh": 1,
  "waktu_diproses": "2025-11-24T02:39:08.625Z",
  "bukti_transfer": "uploads/withdrawal/bukti_transfer-1763951948619-795626920.jpg",
  "users_penarikan_tukang_idTousers": {
    "id": 11,
    "username": "eko_kayu",
    "email": "eko.kayu@gmail.com",
    "nama_lengkap": "Eko Prasetyo",
    "poin": 360000
  },
  "users_penarikan_diproses_olehTousers": {
    "id": 1,
    "username": "admin",
    "nama_lengkap": "Super Administrator"
  }
}
```

### Transaction API Response

```json
{
  "id": 123,
  "nomor_pesanan": "TRX-2024111900123",
  "client_id": 10,
  "tukang_id": 20,
  "kategori_id": 1,
  "judul_layanan": "Renovasi Kamar Tidur",
  "lokasi_kerja": "Jl. Merdeka No. 45, Jakarta",
  "total_biaya": "350000.00",
  "metode_pembayaran": "POIN",
  "status": "selesai",
  "users_transaksi_client_idTousers": {
    "id": 10,
    "username": "client_andi",
    "nama_lengkap": "Andi Pratama"
  },
  "users_transaksi_tukang_idTousers": {
    "id": 20,
    "username": "tukang_budi",
    "nama_lengkap": "Budi Santoso"
  },
  "kategori": {
    "id": 1,
    "nama": "Tukang Bangunan"
  },
  "created_at": "2024-11-19T08:00:00.000Z"
}
```

---

## Files Modified

1. **app/Controllers/Admin/FinanceController.php**

   - Menambahkan mapping `users_penarikan_diproses_olehTousers`
   - Line: ~156

2. **app/Views/admin/finance/withdrawal_list.php**

   - Update display "Diproses Oleh" dengan data dari API
   - Tambah kolom "Bukti Transfer"
   - Tambah modal preview bukti transfer
   - Update colspan dari 10 ke 11
   - Lines: ~73, ~120-131, ~137-146, ~150, ~184-227

3. **app/Controllers/Admin/TransactionController.php**

   - Perbaiki pagination mapping
   - Lines: ~47-60

4. **app/Views/admin/transactions/index.php**
   - Perbaiki mapping data client & tukang
   - Update status filter values
   - Update metode pembayaran values
   - Simplifikasi tabel (hapus kolom Status & Rating)
   - Update DataTable sort column
   - Lines: ~45-51, ~58-60, ~105-109, ~124-167, ~220-226

---

## Environment Variables

Pastikan `.env` file memiliki:

```env
API_BASE_URL=http://localhost:3000
```

Ini digunakan untuk generate URL bukti transfer:

```php
$apiUrl = getenv('API_BASE_URL') ?: 'http://localhost:3000';
$buktiUrl = $apiUrl . '/' . $buktiPath;
```

---

**Tanggal Perbaikan:** 24 November 2025  
**Status:** ✅ Completed
