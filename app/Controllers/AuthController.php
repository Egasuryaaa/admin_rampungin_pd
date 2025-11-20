<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ApiService;

class AuthController extends BaseController
{
    protected $apiService;

    public function __construct()
    {
        $this->apiService = new ApiService();
    }

    /**
     * Display login page
     */
    public function index()
    {
        // If already logged in, redirect to dashboard
        if (session()->has('jwt_token')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('auth/login');
    }

    /**
     * Process login form submission via AJAX
     */
    public function loginProcess()
    {
        // Validate input
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            if ($this->isAjax()) {
                return $this->respondError('Email dan password harus diisi dengan benar');
            }
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email dan password harus diisi dengan benar');
        }

        // Prepare login data
        $loginData = [
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];

        // Call API login endpoint
        $response = $this->apiService->post('/api/auth/login', $loginData);

        // Debug: Log the response structure
        log_message('debug', 'Login API Response: ' . json_encode($response));

        // Check if login successful
        if (!$response['success']) {
            $errorMessage = $response['message'] ?? 'Login gagal. Silakan coba lagi.';
            
            if ($this->isAjax()) {
                return $this->respondError($errorMessage);
            }
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        // Debug: Log user data structure
        log_message('debug', 'User data: ' . json_encode($response['data']['user'] ?? []));

        // Check if user is admin - Try multiple possible structures
        $userRole = null;
        
        // Try structure 1: $response['data']['user']['roles']['name']
        if (isset($response['data']['user']['roles']['name'])) {
            $userRole = $response['data']['user']['roles']['name'];
        }
        // Try structure 2: $response['data']['user']['role']
        elseif (isset($response['data']['user']['role'])) {
            $userRole = $response['data']['user']['role'];
        }
        // Try structure 3: $response['data']['user']['roles'] (direct string or array)
        elseif (isset($response['data']['user']['roles'])) {
            $roleData = $response['data']['user']['roles'];
            if (is_string($roleData)) {
                $userRole = $roleData;
            } elseif (is_array($roleData) && isset($roleData['name'])) {
                $userRole = $roleData['name'];
            } elseif (is_array($roleData) && isset($roleData[0])) {
                $userRole = is_string($roleData[0]) ? $roleData[0] : null;
            }
        }
        // Try structure 4: $response['data']['role'] (string or array with 'name')
        elseif (isset($response['data']['role'])) {
            $roleData = $response['data']['role'];
            if (is_string($roleData)) {
                $userRole = $roleData;
            } elseif (is_array($roleData) && isset($roleData['name'])) {
                $userRole = $roleData['name'];
            }
        }

        $roleDisplay = is_array($userRole) ? json_encode($userRole) : ($userRole ?? 'NOT FOUND');
        log_message('debug', 'Detected user role: ' . $roleDisplay);

        // Validate admin role (case-insensitive)
        if (!$userRole || !is_string($userRole) || strtolower($userRole) !== 'admin') {
            if ($this->isAjax()) {
                return $this->respondError('Akses ditolak. Hanya admin yang dapat login ke panel ini.');
            }
            return redirect()->back()
                ->withInput()
                ->with('error', 'Akses ditolak. Hanya admin yang dapat login ke panel ini.');
        }

        // Save token and user data to session
        $user = $response['data']['user'] ?? [];
        
        $sessionData = [
            'jwt_token' => $response['data']['token'],
            'user_id' => $user['id'] ?? $user['id_user'] ?? null,
            'username' => $user['username'] ?? '',
            'email' => $user['email'] ?? '',
            'nama_lengkap' => $user['nama_lengkap'] ?? $user['fullName'] ?? $user['username'] ?? 'Admin',
            'role' => $userRole,
            'is_logged_in' => true,
        ];

        session()->set($sessionData);

        // Return response based on request type
        if ($this->isAjax()) {
            return $this->respondSuccess(
                'Login berhasil! Selamat datang, ' . $sessionData['nama_lengkap'],
                [
                    'ke_route' => base_url('/admin/dashboard'),
                    'user' => [
                        'nama_lengkap' => $sessionData['nama_lengkap'],
                        'email' => $sessionData['email']
                    ]
                ]
            );
        }

        return redirect()->to('/admin/dashboard')
            ->with('success', 'Login berhasil! Selamat datang, ' . $sessionData['nama_lengkap']);
    }

    /**
     * Logout and destroy session
     */
    public function logout()
    {
        // Destroy session
        session()->destroy();

        // Redirect to login with success message
        return redirect()->to('/auth/login')
            ->with('success', 'Anda telah berhasil logout');
    }

    /**
     * Check if user is authenticated (helper method)
     */
    public function isAuthenticated()
    {
        return session()->has('jwt_token') && session()->has('is_logged_in');
    }
}
