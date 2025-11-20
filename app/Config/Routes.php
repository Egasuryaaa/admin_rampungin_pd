
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (No Authentication Required)
|--------------------------------------------------------------------------
*/

// Redirect root ke login
$routes->get('/', 'Auth::login');

// Login & Auth Routes (HARUS DI LUAR FILTER!)
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::processLogin');
$routes->get('logout', 'Auth::logout');
$routes->get('locked', 'Auth::locked');

// Google Sign-In route for Flutter
$routes->post('api/auth/google', 'Auth::googleSignIn');

// Public file access routes (for uploaded files)
// Note: Harus lebih spesifik untuk menghindari conflict dengan route lain
$routes->get('uploads/profiles/(:any)', '\App\Controllers\FileController::serveProfile/$1');
$routes->get('uploads/topup/(:any)', '\App\Controllers\FileController::serveTopup/$1');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Authentication Required)
|--------------------------------------------------------------------------
*/

$routes->group('', ['filter' => 'adminAuth'], function($routes) {
    // Dashboard (requires authentication)
    $routes->get('dashboard', 'Dashboard::index');
    
    // User Management Routes (Web) - Requires Admin Role
    $routes->group('usermanagement', function($routes) {
        // Halaman daftar
        $routes->get('daftar-user', 'UserManagement::index');
        $routes->get('daftar-tukang', 'UserManagement::daftarTukang');
        $routes->get('roles-and-permissions', 'UserManagement::roles');
        
        // AJAX endpoints untuk datatables
        $routes->get('get-users', 'UserManagement::getUsersAjax');
        $routes->get('get-tukang', 'UserManagement::getTukangAjax');
        
        // CRUD operations
        $routes->get('create', 'UserManagement::create');
        $routes->post('store', 'UserManagement::store');
        $routes->get('view/(:num)', 'UserManagement::view/$1');
        $routes->get('edit/(:num)', 'UserManagement::edit/$1');
        $routes->post('update/(:num)', 'UserManagement::update/$1');
        $routes->post('delete/(:num)', 'UserManagement::delete/$1');
        
        // Actions
        $routes->post('toggle-active/(:num)', 'UserManagement::toggleActive/$1');
        $routes->post('verify-tukang/(:num)', 'UserManagement::verifyTukang/$1');
        $routes->post('unverify-tukang/(:num)', 'UserManagement::unverifyTukang/$1');

        // --- RUTE BARU UNTUK KATEGORI TUKANG ---
        // Arahkan ke KategoriTukangController yang benar
        $routes->get('kategori-tukang', 'KategoriTukangController::index');
        $routes->get('assign-kategori', 'KategoriTukangController::assignKategori');
        $routes->post('process-assign', 'KategoriTukangController::processAssign');
        $routes->get('edit-assignment/(:num)', 'KategoriTukangController::editAssignment/$1');
        $routes->get('delete-assignment/(:num)', 'KategoriTukangController::deleteAssignment/$1');
    });

    $routes->group('wallet-transaksi', function ($routes) {

        // Ini adalah rute untuk halaman utama yang Anda tuju
        // URL: /wallet-transaksi/wallet-tukang
        // Memanggil: WalletTransaksiController -> method walletTukang()
        $routes->get('wallet-tukang', 'WalletTransaksiController::walletTukang');

        // Ini rute untuk menu lainnya (Topup, Withdraw, Transaksi)
        $routes->get('topup', 'WalletTransaksiController::topup');
        $routes->get('withdraw', 'WalletTransaksiController::withdraw');
        $routes->get('semua-transaksi', 'WalletTransaksiController::semuaTransaksi');

        // Ini rute untuk tombol AKSI di tabel (yang ada icon-nya)
        // :num adalah placeholder untuk ID tukang (angka)
        // URL: /wallet-transaksi/detail/7
        $routes->get('detail/(:num)', 'WalletTransaksiController::detail/$1');
        // URL: /wallet-transaksi/history/7
        $routes->get('history/(:num)', 'WalletTransaksiController::history/$1');

        $routes->get('topup-verifikasi/(:num)', 'WalletTransaksiController::topupVerifikasi/$1');

        $routes->get('withdraw-view/(:num)', 'WalletTransaksiController::withdrawView/$1');
        $routes->get('withdraw-proses/(:num)', 'WalletTransaksiController::withdrawProses/$1');

        $routes->get('transaksi-view/(:num)', 'WalletTransaksiController::transaksiView/$1');
    });

    $routes->group('orders', function ($routes) {
        // Daftar Pesanan
        $routes->get('/', 'PesananJasaController::index');

        // Pembayaran Jasa
        $routes->get('payments', 'PesananJasaController::payments');

        // Review & Feedback
        $routes->get('reviews', 'PesananJasaController::reviews');
    });

    $routes->group('categories', function ($routes) {
        // Kategori Tukang
        // [FIX] Arahkan ke controller yang benar yang sudah menyiapkan data
        $routes->get('', 'KategoriTukangController::index');
    });

    // Notifications
    $routes->get('notifications/pending-topups', 'Notifications::pendingTopups');
});


// API Routes for Mobile App (Flutter/React Native)
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    
    /*
    |--------------------------------------------------------------------------
    | AUTH ROUTES (Public - No JWT Required)
    |--------------------------------------------------------------------------
    | Endpoint untuk registrasi dan login (Client & Tukang)
    */
    
    // Register - Client & Tukang (Tukang perlu verifikasi admin)
    $routes->post('auth/register', 'AuthController::register');
    
    // Login - Semua role (Admin, Client, Tukang)
    $routes->post('auth/login', 'AuthController::login');
    
    /*
    |--------------------------------------------------------------------------
    | AUTH ROUTES (Protected - JWT Required)
    |--------------------------------------------------------------------------
    | Endpoint yang memerlukan autentikasi (semua role yang sudah login)
    */
    $routes->group('auth', ['filter' => 'jwt'], function($routes) {
        $routes->post('logout', 'AuthController::logout');
        $routes->get('me', 'AuthController::me');
        $routes->post('change-password', 'AuthController::changePassword');
    });
    
    /*
    |--------------------------------------------------------------------------
    | CLIENT ROUTES (Protected - JWT + Role Client Required)
    |--------------------------------------------------------------------------
    | Flow Client:
    | 1. Register & Login
    | 2. Lihat daftar tukang (berdasarkan kategori, rating, lokasi)
    | 3. Dua pilihan pembayaran:
    |    a. POIN (QRIS) - Top-up dulu → verifikasi admin → sewa tukang
    |    b. TUNAI (Cash on Service) - Langsung sewa, bayar di lokasi
    | 4. Beri rating setelah selesai
    | 5. Lihat riwayat transaksi (POIN & TUNAI)
    */
    $routes->group('client', ['filter' => 'jwt:client'], function($routes) {
        
        // ===== PROFILE MANAGEMENT =====
        $routes->get('profile', 'ClientController::profile');
        $routes->put('profile', 'ClientController::updateProfile');
        $routes->post('profile', 'ClientController::updateProfile'); // Alternative for form-data
        
        // ===== BROWSE TUKANG =====
        // Get categories untuk filter
        $routes->get('categories', 'ClientController::categories');
        
        // Browse tukang (dengan filter: kategori, rating, lokasi)
        $routes->get('tukang', 'ClientController::browseTukang');
        
        // Detail tukang (lihat profil lengkap, rating, ulasan)
        $routes->get('tukang/(:num)', 'ClientController::detailTukang/$1');
        
        // Search tukang by keyword
        $routes->get('search-tukang', 'ClientController::searchTukang');
        
        // ===== BOOKING & PAYMENT =====
        // Create booking (pilih metode: 'poin' atau 'tunai')
        // - POIN: akan auto-deduct saldo poin client
        // - TUNAI: tidak potong poin, bayar cash di lokasi
        $routes->post('booking', 'ClientController::createBooking');
        
        // ===== TOP-UP POIN (QRIS Only) =====
        // Request top-up dengan upload bukti transfer QRIS
        $routes->post('topup', 'ClientController::requestTopup');
        
        // Lihat history top-up (pending, berhasil, ditolak, kadaluarsa)
        $routes->get('topup', 'ClientController::topupHistory');
        
        // ===== TRANSACTION MANAGEMENT =====
        // Lihat semua transaksi (POIN & TUNAI)
        $routes->get('transactions', 'ClientController::transactions');
        
        // Detail transaksi specific
        $routes->get('transactions/(:num)', 'ClientController::transactionDetail/$1');
        
        // Cancel transaksi (hanya jika status: pending atau diterima)
        $routes->put('transactions/(:num)/cancel', 'ClientController::cancelTransaction/$1');
        $routes->post('transactions/(:num)/cancel', 'ClientController::cancelTransaction/$1'); // Alternative
        
        // ===== RATING & REVIEW =====
        // Submit rating setelah transaksi selesai
        $routes->post('rating', 'ClientController::submitRating');
        
        // ===== STATISTICS =====
        // Dashboard client (saldo poin, total transaksi, dll)
        $routes->get('statistics', 'ClientController::statistics');
    });
    
    /*
    |--------------------------------------------------------------------------
    | TUKANG ROUTES (Protected - JWT + Role Tukang Required)
    |--------------------------------------------------------------------------
    | Flow Tukang:
    | 1. Register → Menunggu verifikasi admin (is_verified = false)
    | 2. Setelah verified → Atur profil (nama, keahlian, tarif, lokasi, bio)
    | 3. Terima/Tolak pesanan dari client
    | 4. Update status pekerjaan: "Sedang Dikerjakan" → "Selesai"
    | 5. Lihat riwayat order (POIN & TUNAI)
    | 6. Withdraw poin (hanya untuk transaksi POIN yang sudah selesai)
    */
    $routes->group('tukang', ['filter' => 'jwt:tukang'], function($routes) {
        
        // ===== PROFILE MANAGEMENT =====
        // Get profil tukang lengkap (user + profil_tukang + kategori)
        $routes->get('profile', 'TukangController::profile');
        
        // Update profil tukang (nama, email, keahlian, tarif, lokasi, bio, bank)
        $routes->put('profile', 'TukangController::updateProfile');
        $routes->post('profile', 'TukangController::updateProfile'); // Alternative for form-data
        
        // ===== CATEGORIES =====
        // Get all categories untuk tukang
        $routes->get('categories', 'TukangController::categories');
        
        // Update availability (tersedia / tidak_tersedia)
        $routes->put('availability', 'TukangController::updateAvailability');
        $routes->post('availability', 'TukangController::updateAvailability'); // Alternative
        
        // ===== ORDER MANAGEMENT =====
        // Lihat semua pesanan (pending, diterima, dalam_proses, selesai, ditolak, dibatalkan)
        $routes->get('orders', 'TukangController::orders');
        
        // Detail pesanan specific
        $routes->get('orders/(:num)', 'TukangController::orderDetail/$1');
        
        // Accept order (status: pending → diterima)
        $routes->put('orders/(:num)/accept', 'TukangController::acceptOrder/$1');
        $routes->post('orders/(:num)/accept', 'TukangController::acceptOrder/$1'); // Alternative
        
        // Reject order (status: pending → ditolak + alasan)
        $routes->put('orders/(:num)/reject', 'TukangController::rejectOrder/$1');
        $routes->post('orders/(:num)/reject', 'TukangController::rejectOrder/$1'); // Alternative
        
        // Start work (status: diterima → dalam_proses)
        $routes->put('orders/(:num)/start', 'TukangController::startOrder/$1');
        $routes->post('orders/(:num)/start', 'TukangController::startOrder/$1'); // Alternative
        
        // Complete work (status: dalam_proses → selesai)
        // Untuk POIN: otomatis transfer poin dari client ke tukang
        // Untuk TUNAI: menunggu konfirmasi pembayaran tunai
        $routes->put('orders/(:num)/complete', 'TukangController::completeOrder/$1');
        $routes->post('orders/(:num)/complete', 'TukangController::completeOrder/$1'); // Alternative
        
        // Confirm cash payment (khusus untuk metode TUNAI)
        // Tukang konfirmasi sudah terima uang cash dari client
        $routes->put('orders/(:num)/confirm-tunai', 'TukangController::confirmTunai/$1');
        $routes->post('orders/(:num)/confirm-tunai', 'TukangController::confirmTunai/$1'); // Alternative
        
        // ===== RATINGS & REVIEWS =====
        // Lihat semua rating yang diterima dari client
        $routes->get('ratings', 'TukangController::ratings');
        
        // ===== WITHDRAWAL (Hanya untuk transaksi POIN) =====
        // Request penarikan poin ke rekening bank
        // Minimum: Rp 50,000, Fee: 2% (max Rp 5,000)
        $routes->post('withdrawal', 'TukangController::requestWithdrawal');
        
        // Lihat history withdrawal (pending, diproses, selesai, ditolak)
        $routes->get('withdrawal', 'TukangController::withdrawalHistory');
        
        // ===== STATISTICS =====
        // Dashboard tukang (saldo poin, total order, rating, pendapatan)
        $routes->get('statistics', 'TukangController::statistics');
    });
    
});