# Admin Panel Views - Complete Documentation

## 📁 Project Structure

Struktur views telah direorganisasi dan dioptimalkan dengan menghilangkan duplikasi dan menggunakan template header/footer yang terpusat.

### Directory Structure

```
app/Views/
├── admin/                          # Main admin views directory
│   ├── dashboard.php              # Admin dashboard
│   ├── categories/
│   │   └── index.php              # Categories CRUD
│   ├── finance/
│   │   ├── topup_list.php         # Topup management
│   │   └── withdrawal_list.php    # Withdrawal management
│   ├── transactions/
│   │   └── index.php              # Transaction monitoring
│   └── usermanagement/
│       ├── users_list.php         # All users list
│       └── verifikasi_tukang.php  # Tukang verification
├── auth/
│   └── login.php                  # Admin login page
└── templates/
    ├── navbar.php                 # Sidebar navigation
    ├── header.php                 # HTML head + header (CSS loaded once)
    └── footer.php                 # Footer + scripts (JS loaded once)
```

## ✅ Completed Tasks

### 1. ✅ Created Centralized Templates

- **header.php**: Contains HTML head, CSS links, navbar include, and top header bar
- **footer.php**: Contains footer and all JavaScript files
- **Benefits**: CSS and JS files are now loaded only once per page

### 2. ✅ Removed Duplicate Views

Deleted the following duplicate/old files:

- `app/Views/dashboard.php` (moved to admin/)
- `app/Views/dashboard_content.php` (obsolete)
- `app/Views/finance/` (entire old directory)
- `app/Views/usermanagement/` (entire old directory)
- `app/Views/categories/` (entire old directory)

### 3. ✅ Created New Views

#### Finance Views

- **topup_list.php**
  - DataTables integration
  - Approve/Reject buttons with modals
  - Displays: ID, User, Amount, Method, Status, Date, Proof, Actions
  - Pagination support
- **withdrawal_list.php**
  - File upload form for transfer proof (multipart/form-data)
  - Confirm button with upload modal
  - Reject button with reason modal
  - Displays: ID, User, Amount, Bank Name, Account Number, Owner Name, Status, Date

#### User Management Views

- **users_list.php**
  - Filter dropdowns (role, is_active)
  - Ban/Unban buttons
  - Detail view link
  - Displays: ID, User info, Role, Phone, City, Points, Status, Verification, Actions
- **verifikasi_tukang.php**
  - Card layout for each unverified tukang
  - Shows profile info, bank details, categories
  - Approve/Reject buttons with modals
  - Displays full profil_tukang data

#### Categories View

- **index.php**
  - CRUD interface
  - Create button opens modal
  - Edit/Delete buttons for each category
  - Toggle active/inactive status
  - Displays: ID, Name, Description, Status, Created date

#### Transactions View

- **index.php**
  - Advanced filters (status, payment method, date range)
  - Export to Excel button
  - Displays: Order number, Client, Tukang, Category, Service title, Location, Total, Method, Status, Rating, Date
  - Detail view link
  - Pagination with filter preservation

### 4. ✅ Updated Existing Views

- **dashboard.php**: Now uses `header.php` and `footer.php`
- **topup_list.php**: Now uses `header.php` and `footer.php`

## 🎨 Template System

### Header Template (`templates/header.php`)

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <!-- All CSS files loaded here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" href="assets/css/theme.min.css" />
    <!-- FontAwesome -->
</head>
<body>
    <?php include navbar.php ?>
    <header class="nxl-header">
        <!-- Top header bar with user menu -->
    </header>
```

### Footer Template (`templates/footer.php`)

```php
        <footer class="footer">
            <!-- Copyright and links -->
        </footer>
    </main>

    <!-- All JS files loaded here -->
    <script src="assets/vendors/js/vendors.min.js"></script>
    <script src="assets/vendors/js/daterangepicker.min.js"></script>
    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/theme-customizer-init.min.js"></script>
</body>
</html>
```

### Usage in Views

```php
<?php include APPPATH . 'Views/templates/header.php'; ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <!-- Your page content here -->
        </div>
    </main>

<?php include APPPATH . 'Views/templates/footer.php'; ?>

<!-- Optional: Page-specific scripts -->
<script>
    // Your custom JS here
</script>
```

## 🔗 Route Mappings

All views are accessible through their respective routes:

| View                | Route                               | Controller Method                                       |
| ------------------- | ----------------------------------- | ------------------------------------------------------- |
| Dashboard           | `/admin/dashboard`                  | `Admin\DashboardController::index()`                    |
| Topup List          | `/admin/finance/topup`              | `Admin\FinanceController::topup()`                      |
| Withdrawal List     | `/admin/finance/withdrawal`         | `Admin\FinanceController::withdrawal()`                 |
| All Users           | `/admin/users`                      | `Admin\UserManagementController::users()`               |
| Client List         | `/admin/users/clients`              | `Admin\UserManagementController::clients()`             |
| Tukang List         | `/admin/users/tukang`               | `Admin\UserManagementController::tukang()`              |
| Tukang Verification | `/admin/users/verifications/tukang` | `Admin\UserManagementController::tukangVerifications()` |
| Categories          | `/admin/categories`                 | `Admin\CategoryController::index()`                     |
| Transactions        | `/admin/transactions`               | `Admin\TransactionController::index()`                  |

## 📊 Controller → View Data Flow

### Dashboard

```php
// Controller passes:
$data['stats'] = [
    'users' => ['total' => 150],
    'finance' => ['pending_topup' => 5, 'pending_withdrawal' => 3],
    'verifications' => ['pending_tukang' => 2]
];
```

### Topup List

```php
// Controller passes:
$data['topup_list'] = [
    [
        'id_topup' => 1,
        'user' => ['nama_lengkap', 'email'],
        'jumlah_poin' => 50000,
        'metode_pembayaran' => 'transfer_bank',
        'status' => 'pending',
        'tanggal_topup' => '2024-01-01 10:00:00',
        'bukti_pembayaran' => 'uploads/...'
    ]
];
$data['pagination'] = [
    'current_page' => 1,
    'total_pages' => 5,
    'total' => 50
];
```

### Withdrawal List

```php
// Controller passes:
$data['withdrawal_list'] = [
    [
        'id_penarikan' => 1,
        'user' => ['nama_lengkap', 'email'],
        'jumlah_penarikan' => 100000,
        'nama_bank' => 'BCA',
        'nomor_rekening' => '1234567890',
        'nama_pemilik_rekening' => 'John Doe',
        'status' => 'pending',
        'tanggal_penarikan' => '2024-01-01 10:00:00'
    ]
];
```

### Users List

```php
// Controller passes:
$data['users'] = [
    [
        'id_user' => 1,
        'username' => 'johndoe',
        'email' => 'john@example.com',
        'nama_lengkap' => 'John Doe',
        'role' => 'client',
        'no_telp' => '08123456789',
        'kota' => 'Jakarta',
        'poin' => 50000,
        'is_active' => true,
        'is_verified' => true
    ]
];
```

### Verifikasi Tukang

```php
// Controller passes:
$data['tukang'] = [
    [
        'id_user' => 1,
        'nama_lengkap' => 'John Doe',
        'email' => 'john@example.com',
        'profil_tukang' => [
            'pengalaman_tahun' => 5,
            'tarif_per_jam' => 50000,
            'bio' => '...',
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'nama_pemilik_rekening' => 'John Doe',
            'kategori_tukang' => [
                ['kategori' => ['nama' => 'Tukang Listrik']]
            ]
        ]
    ]
];
```

### Categories

```php
// Controller passes:
$data['categories'] = [
    [
        'id_kategori' => 1,
        'nama' => 'Tukang Listrik',
        'deskripsi' => 'Jasa perbaikan listrik',
        'is_active' => true,
        'created_at' => '2024-01-01 10:00:00'
    ]
];
```

### Transactions

```php
// Controller passes:
$data['transactions'] = [
    [
        'id_pesanan' => 1,
        'nomor_pesanan' => 'ORD-001',
        'client' => ['nama_lengkap' => 'Client Name'],
        'tukang' => ['nama_lengkap' => 'Tukang Name'],
        'kategori' => ['nama' => 'Category'],
        'judul_layanan' => 'Service Title',
        'lokasi_kerja' => 'Location',
        'total_biaya' => 150000,
        'metode_pembayaran' => 'poin',
        'status' => 'selesai',
        'rating' => 4.5,
        'tanggal_pesanan' => '2024-01-01 10:00:00'
    ]
];
```

## 🎯 Form Actions

### Topup Management

- **Approve**: `POST /admin/finance/topup/verify/{id}` with `action=approve`
- **Reject**: `POST /admin/finance/topup/verify/{id}` with `action=reject`, `alasan_penolakan`

### Withdrawal Management

- **Confirm**: `POST /admin/finance/withdrawal/confirm/{id}` with `bukti_transfer` file, `catatan`
- **Reject**: `POST /admin/finance/withdrawal/reject/{id}` with `alasan_penolakan`

### User Management

- **Ban User**: `POST /admin/users/ban/{id}`
- **Unban User**: `POST /admin/users/unban/{id}`

### Tukang Verification

- **Approve**: `POST /admin/users/verifications/tukang/{id}` with `action=approve`
- **Reject**: `POST /admin/users/verifications/tukang/{id}` with `action=reject`, `alasan_penolakan`

### Categories Management

- **Create**: `POST /admin/categories/create` with `nama`, `deskripsi`, `is_active`
- **Update**: `POST /admin/categories/update/{id}` with `nama`, `deskripsi`, `is_active`
- **Delete**: `POST /admin/categories/delete/{id}`

## 🚀 Benefits of New Structure

1. **No Duplicate Views**: All old duplicate files removed
2. **DRY Principle**: Header/Footer included once, reducing code duplication
3. **CSS/JS Optimization**: Assets loaded only once per page
4. **Easier Maintenance**: Update header/footer in one place, affects all pages
5. **Consistent Layout**: All admin pages use the same template structure
6. **Better Organization**: Clear separation between admin, auth, and template files

## 📝 Next Steps for Testing

1. Start the Node.js API backend on port 3000
2. Access admin panel: `http://localhost/admintukang/auth/login`
3. Login with admin credentials
4. Test each view:
   - Dashboard statistics
   - Topup approve/reject
   - Withdrawal confirm/reject
   - User management filters and ban/unban
   - Tukang verification
   - Categories CRUD
   - Transactions filtering and export

## 🔧 Troubleshooting

### CSS/JS Not Loading

- Check `base href="<?= base_url() ?>"` in header.php
- Verify assets folder path in your web server

### Views Not Found

- Clear CodeIgniter cache: `writable/cache/`
- Check Routes.php configuration
- Verify controller namespace: `App\Controllers\Admin\`

### API Connection Issues

- Verify NODE_API_URL in .env file
- Check Node.js backend is running on port 3000
- Test API endpoints with Postman

## 📚 Related Documentation

- `ADMIN_PANEL_SETUP.md` - Initial setup guide
- `QUICK_REFERENCE.md` - Quick reference for developers
- `INTEGRATION_GUIDE.md` - API integration details
- `app/Config/Routes.php` - Complete route definitions

---

**Last Updated**: <?= date('Y-m-d H:i:s') ?>  
**Status**: ✅ All views created and optimized  
**Duplicate Files**: ❌ Removed  
**Template System**: ✅ Implemented
