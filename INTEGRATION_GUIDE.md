# Panduan Integrasi Views dengan Controller API Node.js

## ✅ File yang Sudah Dibuat/Diperbaiki

### 1. **Authentication & Routing**

- ✅ `app/Views/auth/login.php` - Form login dengan CSRF dan flash messages
- ✅ `app/Config/Routes.php` - Routes lengkap dengan filter adminauth
- ✅ `app/Controllers/AuthController.php` - Login menggunakan API `/api/auth/login`

### 2. **Dashboard**

- ✅ `app/Views/admin/dashboard.php` - Dashboard dengan statistik dari API
- ✅ `app/Controllers/Admin/DashboardController.php` - Fetch data dari `/api/admin/dashboard`

### 3. **Finance Management**

- ✅ `app/Views/admin/finance/topup_list.php` - List topup dengan approve/reject
- ✅ `app/Controllers/Admin/FinanceController.php` - CRUD topup dan withdrawal

### 4. **Navigation**

- ✅ `app/Views/templates/navbar.php` - Menu navigasi dengan routes yang baru

## 📋 Views yang Perlu Dibuat

### 1. Withdrawal List (`app/Views/admin/finance/withdrawal_list.php`)

```php
<!-- Mirip dengan topup_list.php tapi dengan: -->
- Form upload bukti transfer (multipart/form-data)
- Button "Konfirmasi" dan "Tolak"
- Menampilkan data bank tukang
```

### 2. User List (`app/Views/admin/usermanagement/users_list.php`)

```php
<!-- Table list semua users dengan: -->
- Filter by role (client/tukang)
- Filter by status (active/inactive)
- Button Ban/Unban
- Link ke detail user
```

### 3. Tukang Verification (`app/Views/admin/usermanagement/verifikasi-tukang.php`)

```php
<!-- List tukang yang belum verified dengan: -->
- Menampilkan profil tukang lengkap
- Menampilkan kategori keahlian
- Button Approve/Reject
```

## 🔧 Cara Menggunakan

### Login

1. Buka: `http://localhost/admintukang/auth/login`
2. Masukkan email dan password admin
3. Sistem akan:
   - Kirim request ke `/api/auth/login`
   - Validasi role = admin
   - Simpan JWT token ke session
   - Redirect ke dashboard

### Dashboard

1. URL: `http://localhost/admintukang/admin/dashboard`
2. Protected dengan AdminAuthFilter
3. Data diambil dari API `/api/admin/dashboard`
4. Menampilkan:
   - Total users (client, tukang, admin)
   - Pending topup
   - Pending withdrawal
   - Unverified tukang
   - Summary transaksi

### Top-Up Management

1. URL: `http://localhost/admintukang/admin/finance/topup`
2. List semua topup pending
3. Action:
   - **Approve**: POST ke `/api/admin/finance/topup/:id` dengan `action=approve`
   - **Reject**: POST dengan `action=reject` dan `alasan_penolakan`

### Withdrawal Management

1. URL: `http://localhost/admintukang/admin/finance/withdrawal`
2. List semua withdrawal pending
3. Action:
   - **Confirm**: POST multipart-form dengan file `bukti_transfer`
   - **Reject**: POST dengan `alasan_penolakan`

## 📊 Struktur Data dari API

### Dashboard Stats

```json
{
  "users": {
    "total": 150,
    "client": 100,
    "tukang": 48,
    "admin": 2
  },
  "finance": {
    "pending_topup": 5,
    "pending_withdrawal": 3
  },
  "verifications": {
    "unverified_tukang": 7
  },
  "transactions": {
    "total": 523,
    "pending": 12,
    "completed": 487
  }
}
```

### Topup List Response

```json
{
  "topup": [
    {
      "id": 42,
      "user_id": 10,
      "jumlah": "100000.00",
      "metode_pembayaran": "qris",
      "bukti_pembayaran": "uploads/topup/bukti-xxx.jpg",
      "status": "pending",
      "users_topup_user_idTousers": {
        "id": 10,
        "username": "client_andi",
        "email": "andi@example.com",
        "nama_lengkap": "Andi Pratama"
      }
    }
  ],
  "pagination": {
    "page": 1,
    "limit": 20,
    "total": 5,
    "total_pages": 1
  }
}
```

## 🔐 Session Data Structure

Setelah login berhasil, session berisi:

```php
[
    'jwt_token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...',
    'user_id' => 1,
    'username' => 'admin',
    'email' => 'admin@example.com',
    'nama_lengkap' => 'Admin System',
    'role' => 'admin',
    'is_logged_in' => true
]
```

## 🛣️ Routes Reference

### Public Routes (No Auth)

- `GET /` - Redirect ke dashboard atau login
- `GET /auth/login` - Form login
- `POST /auth/login` - Process login
- `GET /auth/logout` - Logout
- `GET /login` - Alias untuk `/auth/login`

### Protected Admin Routes (Requires adminauth filter)

- `GET /admin/dashboard` - Dashboard
- `GET /admin/finance/topup` - List topup
- `POST /admin/finance/topup/verify/:id` - Approve/Reject topup
- `GET /admin/finance/withdrawal` - List withdrawal
- `POST /admin/finance/withdrawal/confirm/:id` - Confirm withdrawal
- `POST /admin/finance/withdrawal/reject/:id` - Reject withdrawal
- `GET /admin/users` - All users
- `GET /admin/users/clients` - Clients only
- `GET /admin/users/tukang` - Tukang only
- `POST /admin/users/ban/:id` - Ban user
- `POST /admin/users/unban/:id` - Unban user
- `GET /admin/users/verifications/tukang` - Unverified tukang
- `POST /admin/users/verifications/tukang/:id` - Verify tukang
- `GET /admin/categories` - List categories
- `GET /admin/transactions` - List transactions

## 🐛 Troubleshooting

### Error: "Session expired"

- Cek `NODE_API_URL` di `.env`
- Pastikan Node.js backend running di port 3000
- Clear session: `session()->destroy()`

### Error: 404 Not Found

- Cek routes di `app/Config/Routes.php`
- Pastikan `.htaccess` sudah benar
- Verify `app.baseURL` di `.env`

### Error: "Akses ditolak"

- Pastikan user login sebagai admin
- Check session: `session()->get('role')` harus 'admin'

### Data tidak muncul

- Check API response dengan console log atau var_dump
- Pastikan controller passing data ke view dengan benar
- Check nama variabel di view sesuai dengan controller

## 📝 TODO - Views yang Masih Perlu Dibuat

1. ❌ `app/Views/admin/finance/withdrawal_list.php`
2. ❌ `app/Views/admin/usermanagement/users_list.php`
3. ❌ `app/Views/admin/usermanagement/verifikasi-tukang.php`
4. ❌ `app/Views/admin/categories/index.php`
5. ❌ `app/Views/admin/transactions/index.php`

## 💡 Tips

1. **Selalu check flash messages** di setiap view untuk menampilkan feedback
2. **Gunakan csrf_field()** di setiap form POST
3. **Escape output** dengan `esc()` function
4. **Check API response** di controller sebelum passing ke view
5. **Gunakan pagination** dari API untuk list data

---

**Last Updated:** November 20, 2025
**Status:** Dashboard, Login, Topup List - COMPLETE ✅
