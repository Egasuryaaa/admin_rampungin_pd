# Admin Panel Infrastructure - Setup Guide

## 📋 Overview

This admin panel is built using CodeIgniter 4 and connects to a Node.js backend API. All data operations are handled through API calls - no local database models are used.

---

## 🏗️ Architecture

```
Frontend (CodeIgniter 4)
    ↓
ApiService Library (HTTP Client)
    ↓
Node.js Backend API (Port 3000)
    ↓
PostgreSQL Database
```

---

## ✅ What Has Been Created

### 1. **ApiService Library** (`app/Libraries/ApiService.php`)

- Handles all HTTP requests to Node.js backend
- Automatically manages JWT token authentication
- Provides convenience methods: `get()`, `post()`, `put()`, `delete()`
- Handles 401 errors (token expiration) automatically

**Usage Example:**

```php
$apiService = new ApiService();
$response = $apiService->get('/api/admin/dashboard');

if ($response['success']) {
    $data = $response['data'];
    // Use the data
}
```

### 2. **Controllers Created**

#### a. `AuthController.php`

- **Routes:**

  - `GET /auth/login` - Display login form
  - `POST /auth/login` - Process login
  - `GET /auth/logout` - Logout

- **Features:**
  - Validates admin role before allowing login
  - Saves JWT token to session
  - Redirects to dashboard after successful login

#### b. `Admin\DashboardController.php`

- **Routes:**
  - `GET /admin/dashboard` - Display dashboard with statistics
  - `GET /admin/dashboard/stats` - AJAX endpoint for stats
  - `GET /admin/dashboard/activities` - Get recent activities

#### c. `Admin\FinanceController.php`

- **Routes:**

  - `GET /admin/finance/topup` - List pending top-ups
  - `POST /admin/finance/topup/verify/:id` - Approve/reject top-up
  - `GET /admin/finance/withdrawal` - List pending withdrawals
  - `POST /admin/finance/withdrawal/confirm/:id` - Confirm withdrawal (requires file upload)
  - `POST /admin/finance/withdrawal/reject/:id` - Reject withdrawal

- **Features:**
  - File upload validation for withdrawal proof (max 2MB, JPG/PNG/PDF)
  - Automatic poin management through API

#### d. `Admin\UserManagementController.php`

- **Routes:**
  - `GET /admin/users` - List all users
  - `GET /admin/users/clients` - List clients only
  - `GET /admin/users/tukang` - List tukang only
  - `POST /admin/users/ban/:id` - Ban user
  - `POST /admin/users/unban/:id` - Unban user
  - `GET /admin/users/verifications/tukang` - List unverified tukang
  - `POST /admin/users/verifications/tukang/:id` - Verify tukang

#### e. `Admin\CategoryController.php`

- **Routes:**
  - `GET /admin/categories` - List categories
  - `GET /admin/categories/create` - Create form
  - `POST /admin/categories/store` - Store new category
  - `GET /admin/categories/edit/:id` - Edit form
  - `POST /admin/categories/update/:id` - Update category
  - `POST /admin/categories/delete/:id` - Soft delete category

#### f. `Admin\TransactionController.php`

- **Routes:**
  - `GET /admin/transactions` - List transactions with filters
  - `GET /admin/transactions/detail/:id` - Transaction detail
  - `GET /admin/transactions/export` - Export to CSV

### 3. **AdminAuthFilter** (`app/Filters/AdminAuthFilter.php`)

- Updated to work with JWT authentication
- Checks for `jwt_token` and `is_logged_in` in session
- Verifies user role is 'admin'
- Auto-redirects to login if not authenticated

### 4. **Routes Configuration** (`app/Config/Routes.php`)

- Complete routing setup with admin group
- All admin routes protected by `adminauth` filter
- Named routes for easy URL generation
- Public routes for login/logout

### 5. **Environment Configuration** (`.env`)

- Added `NODE_API_URL` configuration
- Default: `http://localhost:3000`

---

## 🚀 Getting Started

### Step 1: Configure Your Environment

Make sure your `.env` file has the correct API URL:

```env
NODE_API_URL = http://localhost:3000
```

For production, change this to your production API URL:

```env
NODE_API_URL = https://api.rampungin.com
```

### Step 2: Start Your Node.js Backend

Make sure your Node.js backend is running on port 3000:

```bash
cd /path/to/nodejs-backend
npm start
```

### Step 3: Access the Admin Panel

1. Open your browser and go to: `http://localhost/admintukang`
2. You'll be redirected to the login page
3. Login with admin credentials:
   - Email: (your admin email)
   - Password: (your admin password)

---

## 📝 How to Use ApiService in Your Controllers

### Example 1: GET Request with Filters

```php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ApiService;

class MyController extends BaseController
{
    protected $apiService;

    public function __construct()
    {
        $this->apiService = new ApiService();
    }

    public function index()
    {
        // GET request with query parameters
        $response = $this->apiService->get('/api/admin/users', [
            'role' => 'client',
            'page' => 1,
            'limit' => 20
        ]);

        // Check for authentication errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Check if successful
        if ($response['success']) {
            $users = $response['data']['users'];
            // Use the data
        }
    }
}
```

### Example 2: POST Request

```php
public function create()
{
    $data = [
        'nama' => $this->request->getPost('nama'),
        'email' => $this->request->getPost('email')
    ];

    $response = $this->apiService->post('/api/admin/users', $data);

    if ($response['success']) {
        return redirect()->to('/admin/users')
            ->with('success', 'User created successfully');
    } else {
        return redirect()->back()
            ->with('error', $response['message']);
    }
}
```

### Example 3: File Upload

```php
public function uploadProof($id)
{
    $file = $this->request->getFile('bukti_transfer');

    $response = $this->apiService->put(
        "/api/admin/withdrawal/{$id}/confirm",
        [], // No body data
        ['bukti_transfer' => $file] // Files parameter
    );

    if ($response['success']) {
        return redirect()->back()
            ->with('success', 'Proof uploaded successfully');
    }
}
```

---

## 🔒 Session Data Structure

After successful login, the following data is stored in session:

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

### Accessing Session Data in Views:

```php
<!-- Display logged-in user name -->
<p>Welcome, <?= session()->get('nama_lengkap') ?></p>

<!-- Check if logged in -->
<?php if (session()->get('is_logged_in')): ?>
    <a href="/auth/logout">Logout</a>
<?php endif; ?>
```

---

## 🎨 Creating Views

Your views should display the data passed from controllers. Here's a basic example:

### Example: Dashboard View (`app/Views/admin/dashboard.php`)

```php
<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container">
    <h1>Dashboard</h1>

    <?php if (!empty($stats)): ?>
        <div class="row">
            <!-- Total Users -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Total Users</h5>
                        <h2><?= $stats['users']['total'] ?? 0 ?></h2>
                    </div>
                </div>
            </div>

            <!-- Total Clients -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Clients</h5>
                        <h2><?= $stats['users']['client'] ?? 0 ?></h2>
                    </div>
                </div>
            </div>

            <!-- Total Tukang -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Tukang</h5>
                        <h2><?= $stats['users']['tukang'] ?? 0 ?></h2>
                    </div>
                </div>
            </div>

            <!-- Pending Topups -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Pending Topup</h5>
                        <h2><?= $stats['finance']['pending_topup'] ?? 0 ?></h2>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            Failed to load dashboard statistics
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
```

---

## 🧪 Testing Your Setup

### Test 1: Check API Connection

Create a test controller to verify API connection:

```php
<?php

namespace App\Controllers;

use App\Libraries\ApiService;

class TestController extends BaseController
{
    public function testApi()
    {
        $apiService = new ApiService();

        echo "<h2>Testing API Connection</h2>";
        echo "<p>Base URL: " . $apiService->getBaseUrl() . "</p>";

        // Test endpoint (no auth required)
        $response = $apiService->get('/api/health'); // If you have a health endpoint

        echo "<pre>";
        print_r($response);
        echo "</pre>";
    }
}
```

Add route in `Routes.php`:

```php
$routes->get('test/api', 'TestController::testApi');
```

Access: `http://localhost/admintukang/test/api`

---

## 🐛 Troubleshooting

### Issue 1: "Session expired" error immediately after login

**Solution:**

- Check if `NODE_API_URL` is correct in `.env`
- Verify Node.js backend is running
- Check API endpoint returns correct JWT token

### Issue 2: 404 errors on admin routes

**Solution:**

- Make sure `.htaccess` is properly configured
- Check `app.baseURL` in `.env` matches your setup
- Verify routes in `app/Config/Routes.php`

### Issue 3: CURL errors

**Solution:**

- Enable CURL extension in `php.ini`:
  ```ini
  extension=curl
  ```
- Restart Apache/PHP-FPM

### Issue 4: File upload not working

**Solution:**

- Check `php.ini` settings:
  ```ini
  upload_max_filesize = 10M
  post_max_size = 10M
  ```
- Ensure `writable/` folder has write permissions

---

## 📚 Next Steps

1. **Create Views**: Create view files for each controller action
2. **Add Validation**: Add more validation rules as needed
3. **Error Handling**: Implement proper error pages
4. **AJAX**: Add AJAX functionality for better UX
5. **Testing**: Write unit tests for controllers

---

## 🔗 API Endpoints Reference

Refer to `listapiadmin.txt` for complete API documentation including:

- All available endpoints
- Request/response formats
- Authentication requirements
- Example CURL commands

---

## 💡 Tips

1. **Always check `$response['success']`** before using data
2. **Handle authentication redirects** with `isset($response['redirect'])`
3. **Use named routes** for easier URL generation: `route_to('admin.dashboard')`
4. **Flash messages**: Use `with('success', 'message')` for user feedback
5. **Don't use Models**: All data comes from API, never query database directly

---

## 📞 Support

If you encounter any issues:

1. Check Apache/PHP error logs
2. Check Node.js backend logs
3. Enable CI4 debug mode in `.env`: `CI_ENVIRONMENT = development`
4. Check browser console for JavaScript errors

---

**Last Updated:** November 20, 2025
**Version:** 1.0.0
