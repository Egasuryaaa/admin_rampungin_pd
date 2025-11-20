# Admin Panel - Quick Reference Cheat Sheet

## 🚀 Quick Start

### 1. Start Backend API

```bash
# Make sure Node.js backend is running
cd /path/to/backend
npm start
# API should be running on http://localhost:3000
```

### 2. Login to Admin Panel

```
URL: http://localhost/admintukang
Email: admin@example.com
Password: admin123
```

---

## 📁 File Structure

```
admintukang/
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php                    # Login/Logout
│   │   └── Admin/
│   │       ├── DashboardController.php           # Dashboard stats
│   │       ├── FinanceController.php             # Topup/Withdrawal
│   │       ├── UserManagementController.php      # Users/Tukang
│   │       ├── CategoryController.php            # Categories
│   │       └── TransactionController.php         # Transactions
│   │
│   ├── Libraries/
│   │   └── ApiService.php                        # API HTTP Client
│   │
│   ├── Filters/
│   │   └── AdminAuthFilter.php                   # Auth protection
│   │
│   └── Config/
│       ├── Routes.php                            # URL routing
│       └── Filters.php                           # Filter config
│
└── .env                                          # Environment config
```

---

## 🔧 Common Code Snippets

### Using ApiService in Controllers

```php
<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ApiService;

class YourController extends BaseController
{
    protected $apiService;

    public function __construct()
    {
        $this->apiService = new ApiService();
    }

    public function index()
    {
        // GET request
        $response = $this->apiService->get('/api/admin/endpoint', [
            'page' => 1,
            'limit' => 20
        ]);

        // Always check redirect first (401 errors)
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Then check success
        if ($response['success']) {
            $data = $response['data'];
            return view('your_view', ['data' => $data]);
        } else {
            return view('your_view', [
                'error' => true,
                'message' => $response['message']
            ]);
        }
    }

    public function create()
    {
        // POST request
        $data = [
            'field1' => $this->request->getPost('field1'),
            'field2' => $this->request->getPost('field2')
        ];

        $response = $this->apiService->post('/api/admin/endpoint', $data);

        if ($response['success']) {
            return redirect()->to('/admin/success-page')
                ->with('success', 'Created successfully!');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', $response['message']);
        }
    }

    public function update($id)
    {
        // PUT request
        $data = [
            'field1' => $this->request->getPost('field1')
        ];

        $response = $this->apiService->put("/api/admin/endpoint/{$id}", $data);

        if ($response['success']) {
            return redirect()->back()
                ->with('success', 'Updated successfully!');
        } else {
            return redirect()->back()
                ->with('error', $response['message']);
        }
    }

    public function uploadFile($id)
    {
        // File upload
        $file = $this->request->getFile('file_field');

        $response = $this->apiService->put(
            "/api/admin/endpoint/{$id}",
            [],                         // Body data (empty if only file)
            ['file_field' => $file]     // Files parameter
        );

        if ($response['success']) {
            return redirect()->back()
                ->with('success', 'File uploaded!');
        }
    }
}
```

---

## 🛣️ Route Patterns

### Adding New Routes

Edit `app/Config/Routes.php`:

```php
// Inside admin group
$routes->group('admin', ['filter' => 'adminauth'], function($routes) {

    // Your new routes here
    $routes->get('yourpage', 'Admin\YourController::index');
    $routes->post('yourpage/create', 'Admin\YourController::create');
    $routes->get('yourpage/edit/(:num)', 'Admin\YourController::edit/$1');
    $routes->post('yourpage/update/(:num)', 'Admin\YourController::update/$1');
    $routes->post('yourpage/delete/(:num)', 'Admin\YourController::delete/$1');

});
```

---

## 🔐 Session Management

### Get Session Data

```php
// In controllers
$userId = session()->get('user_id');
$userName = session()->get('nama_lengkap');
$role = session()->get('role');

// In views
<?= session()->get('nama_lengkap') ?>
```

### Check if Logged In

```php
// In controllers
if (!session()->has('jwt_token')) {
    return redirect()->to('/auth/login');
}

// In views
<?php if (session()->get('is_logged_in')): ?>
    <!-- Logged in content -->
<?php endif; ?>
```

---

## 🎨 View Patterns

### Basic View Structure

```php
<!-- app/Views/admin/yourview.php -->

<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container">
    <h1><?= $page_title ?></h1>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Your content here -->
    <?php if (!empty($data)): ?>
        <?php foreach ($data as $item): ?>
            <div class="card">
                <h5><?= esc($item['title']) ?></h5>
                <p><?= esc($item['description']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No data available</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
```

### Pagination

```php
<?php if (!empty($pagination)): ?>
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                <li class="page-item <?= $i == $pagination['page'] ? 'active' : '' ?>">
                    <a href="?page=<?= $i ?>" class="page-link"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>
```

---

## 📋 Available Routes

### Authentication

- `GET /auth/login` - Login page
- `POST /auth/login` - Process login
- `GET /auth/logout` - Logout

### Dashboard

- `GET /admin/dashboard` - Main dashboard

### Finance

- `GET /admin/finance/topup` - Topup list
- `POST /admin/finance/topup/verify/{id}` - Verify topup
- `GET /admin/finance/withdrawal` - Withdrawal list
- `POST /admin/finance/withdrawal/confirm/{id}` - Confirm withdrawal
- `POST /admin/finance/withdrawal/reject/{id}` - Reject withdrawal

### Users

- `GET /admin/users` - All users
- `GET /admin/users/clients` - Clients only
- `GET /admin/users/tukang` - Tukang only
- `POST /admin/users/ban/{id}` - Ban user
- `POST /admin/users/unban/{id}` - Unban user

### Verifications

- `GET /admin/users/verifications/tukang` - Unverified tukang
- `POST /admin/users/verifications/tukang/{id}` - Verify tukang

### Categories

- `GET /admin/categories` - Categories list
- `POST /admin/categories/store` - Create category
- `POST /admin/categories/update/{id}` - Update category
- `POST /admin/categories/delete/{id}` - Delete category

### Transactions

- `GET /admin/transactions` - Transactions list
- `GET /admin/transactions/detail/{id}` - Transaction detail
- `GET /admin/transactions/export` - Export CSV

---

## 🐛 Debug Checklist

### API Not Responding?

1. ✅ Check Node.js backend is running: `http://localhost:3000`
2. ✅ Verify `NODE_API_URL` in `.env`
3. ✅ Test API directly with browser/Postman
4. ✅ Check Node.js console for errors

### Login Not Working?

1. ✅ Check credentials are correct
2. ✅ Verify user role is 'admin' in database
3. ✅ Check API `/api/auth/login` endpoint
4. ✅ Look at browser console for errors

### Routes Not Found (404)?

1. ✅ Check `.htaccess` file exists
2. ✅ Verify `app.baseURL` in `.env`
3. ✅ Check route definition in `Routes.php`
4. ✅ Clear CI4 cache: delete `writable/cache/*`

### Session Issues?

1. ✅ Check `writable/session/` is writable
2. ✅ Verify session settings in `app/Config/Session.php`
3. ✅ Clear browser cookies
4. ✅ Check PHP session configuration

---

## 💾 Environment Variables

```env
# .env file

CI_ENVIRONMENT = development

app.baseURL = 'http://localhost/admintukang/'

# Node.js API URL
NODE_API_URL = http://localhost:3000

# Database (if needed locally)
database.default.hostname = localhost
database.default.database = admintukang
database.default.username = postgres
database.default.password = postgres
database.default.DBDriver = Postgre
database.default.port = 5432

# Encryption
encryption.key = rampungin.id

# JWT
JWT_SECRET_KEY = rampungin.id
jwt.expire = 2592000
```

---

## 📊 API Response Structure

### Success Response

```json
{
  "success": true,
  "status": "success",
  "message": "Operation successful",
  "data": {
    /* your data */
  },
  "http_code": 200
}
```

### Error Response

```json
{
  "success": false,
  "status": "error",
  "message": "Error message",
  "http_code": 400
}
```

### Token Expired (401)

```json
{
  "success": false,
  "status": "error",
  "message": "Session expired. Please login again.",
  "http_code": 401,
  "redirect": "/auth/login"
}
```

---

## 🔨 Common Tasks

### Add New Admin Page

1. Create controller in `app/Controllers/Admin/YourController.php`
2. Add routes in `app/Config/Routes.php`
3. Create view in `app/Views/admin/yourpage.php`
4. Test at `http://localhost/admintukang/admin/yourpage`

### Add Menu Item

Edit your layout file (usually `app/Views/layouts/admin.php`):

```php
<li>
    <a href="<?= base_url('admin/yourpage') ?>">
        <i class="icon"></i> Your Page
    </a>
</li>
```

### Add Form Validation

```php
$rules = [
    'field1' => 'required|min_length[3]',
    'field2' => 'required|valid_email',
];

if (!$this->validate($rules)) {
    return redirect()->back()
        ->withInput()
        ->with('errors', $this->validator->getErrors());
}
```

---

## 🎯 Best Practices

1. ✅ Always use ApiService for API calls
2. ✅ Never query database directly (use API)
3. ✅ Always check `$response['redirect']` first
4. ✅ Use `esc()` for output in views
5. ✅ Use flash messages for user feedback
6. ✅ Validate input before sending to API
7. ✅ Handle file uploads with validation
8. ✅ Log errors for debugging
9. ✅ Use named routes when possible
10. ✅ Keep controllers thin, logic in API

---

**Made with ❤️ for Rampungin Admin Panel**
