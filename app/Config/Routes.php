<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =====================================================
// PUBLIC ROUTES (No Authentication Required)
// =====================================================

// Root route - redirect to login or dashboard
$routes->get('/', function() {
    if (session()->has('jwt_token') && session()->get('is_logged_in')) {
        return redirect()->to('/admin/dashboard');
    }
    return redirect()->to('/auth/login');
});

// Authentication Routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'AuthController::index', ['as' => 'login']);
    $routes->post('login', 'AuthController::loginProcess', ['as' => 'login.process']);
    $routes->get('logout', 'AuthController::logout', ['as' => 'logout']);
});

// Legacy login routes (for backward compatibility)
$routes->get('login', 'AuthController::index');
$routes->post('login', 'AuthController::loginProcess');
$routes->get('logout', 'AuthController::logout');

// Redirect old dashboard route to new one
$routes->get('dashboard', function() {
    return redirect()->to('/admin/dashboard');
});

// =====================================================
// ADMIN ROUTES (Authentication Required)
// =====================================================

$routes->group('admin', ['filter' => 'adminAuth'], function($routes) {
    
    // Dashboard
    $routes->get('dashboard', 'Admin\DashboardController::index', ['as' => 'admin.dashboard']);
    $routes->get('dashboard/stats', 'Admin\DashboardController::getStats', ['as' => 'admin.dashboard.stats']);
    $routes->get('dashboard/activities', 'Admin\DashboardController::getRecentActivities', ['as' => 'admin.dashboard.activities']);

    // =====================================================
    // FINANCE MANAGEMENT
    // =====================================================
    
    $routes->group('finance', function($routes) {
        
        // Top-Up Management
        $routes->get('topup', 'Admin\FinanceController::topup', ['as' => 'admin.finance.topup']);
        $routes->post('topup/verify/(:num)', 'Admin\FinanceController::verifyTopup/$1', ['as' => 'admin.finance.topup.verify']);
        $routes->get('topup/detail/(:num)', 'Admin\FinanceController::getTopupDetail/$1', ['as' => 'admin.finance.topup.detail']);
        
        // Withdrawal Management
        $routes->get('withdrawal', 'Admin\FinanceController::withdrawal', ['as' => 'admin.finance.withdrawal']);
        $routes->post('withdrawal/confirm/(:num)', 'Admin\FinanceController::confirmWithdrawal/$1', ['as' => 'admin.finance.withdrawal.confirm']);
        $routes->post('withdrawal/reject/(:num)', 'Admin\FinanceController::rejectWithdrawal/$1', ['as' => 'admin.finance.withdrawal.reject']);
        $routes->get('withdrawal/detail/(:num)', 'Admin\FinanceController::getWithdrawalDetail/$1', ['as' => 'admin.finance.withdrawal.detail']);
    });

    // =====================================================
    // USER MANAGEMENT
    // =====================================================
    
    $routes->group('users', function($routes) {
        
        // User Listing
        $routes->get('/', 'Admin\UserManagementController::index', ['as' => 'admin.users']);
        $routes->get('clients', 'Admin\UserManagementController::clients', ['as' => 'admin.users.clients']);
        $routes->get('tukang', 'Admin\UserManagementController::tukang', ['as' => 'admin.users.tukang']);
        
        // User Status Management
        $routes->post('status/(:num)', 'Admin\UserManagementController::updateStatus/$1', ['as' => 'admin.users.status']);
        $routes->post('ban/(:num)', 'Admin\UserManagementController::banUser/$1', ['as' => 'admin.users.ban']);
        $routes->post('unban/(:num)', 'Admin\UserManagementController::unbanUser/$1', ['as' => 'admin.users.unban']);
        
        // User Detail (AJAX)
        $routes->get('detail/(:num)', 'Admin\UserManagementController::getUserDetail/$1', ['as' => 'admin.users.detail']);
        
        // Tukang Verification
        $routes->get('verifications/tukang', 'Admin\UserManagementController::unverifiedTukang', ['as' => 'admin.verifications.tukang']);
        $routes->post('verifications/tukang/(:num)', 'Admin\UserManagementController::verifyTukang/$1', ['as' => 'admin.verifications.tukang.verify']);
    });

    // =====================================================
    // CATEGORY MANAGEMENT (if you need it later)
    // =====================================================
    
    $routes->group('categories', function($routes) {
        $routes->get('/', 'Admin\CategoryController::index', ['as' => 'admin.categories']);
        $routes->post('create', 'Admin\CategoryController::create', ['as' => 'admin.categories.create']);
        $routes->post('update/(:num)', 'Admin\CategoryController::update/$1', ['as' => 'admin.categories.update']);
        $routes->post('delete/(:num)', 'Admin\CategoryController::delete/$1', ['as' => 'admin.categories.delete']);
    });

    // =====================================================
    // TRANSACTION MONITORING (if you need it later)
    // =====================================================
    
    $routes->group('transactions', function($routes) {
        $routes->get('/', 'Admin\TransactionController::index', ['as' => 'admin.transactions']);
        $routes->get('export', 'Admin\TransactionController::export', ['as' => 'admin.transactions.export']);
        $routes->get('detail/(:num)', 'Admin\TransactionController::detail/$1', ['as' => 'admin.transactions.detail']);
    });

    // =====================================================
    // REPORTS (if you need it later)
    // =====================================================
    
    $routes->group('reports', function($routes) {
        $routes->get('/', 'Admin\ReportController::index', ['as' => 'admin.reports']);
        $routes->get('revenue', 'Admin\ReportController::revenue', ['as' => 'admin.reports.revenue']);
        $routes->get('users', 'Admin\ReportController::users', ['as' => 'admin.reports.users']);
        $routes->get('transactions', 'Admin\ReportController::transactions', ['as' => 'admin.reports.transactions']);
    });

    // =====================================================
    // SETTINGS (if you need it later)
    // =====================================================
    
    $routes->group('settings', function($routes) {
        $routes->get('/', 'Admin\SettingsController::index', ['as' => 'admin.settings']);
        $routes->post('update', 'Admin\SettingsController::update', ['as' => 'admin.settings.update']);
    });
});

// =====================================================
// API ROUTES (if you want to add AJAX endpoints)
// =====================================================

$routes->group('api', ['filter' => 'adminAuth'], function($routes) {
    
    // Dashboard Stats
    $routes->get('dashboard/stats', 'Admin\DashboardController::getStats');
    
    // User Data
    $routes->get('users/(:num)', 'Admin\UserManagementController::getUserDetail/$1');
    
    // Finance Data
    $routes->get('finance/topup/(:num)', 'Admin\FinanceController::getTopupDetail/$1');
    $routes->get('finance/withdrawal/(:num)', 'Admin\FinanceController::getWithdrawalDetail/$1');
});

// =====================================================
// ERROR ROUTES
// =====================================================

// 404 Override
$routes->set404Override(function() {
    return view('errors/html/error_404');
});

// =====================================================
// CLI ROUTES (for spark commands)
// =====================================================

// You can add CLI-specific routes here if needed
