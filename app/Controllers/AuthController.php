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
     * Process login form submission
     */
    public function loginProcess()
    {
        // Validate input
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
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

        // Check if login successful
        if (!$response['success']) {
            $errorMessage = $response['message'] ?? 'Login gagal. Silakan coba lagi.';
            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        // Check if user is admin
        if (!isset($response['data']['user']['roles']) || $response['data']['user']['roles']['name'] !== 'admin') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Akses ditolak. Hanya admin yang dapat login ke panel ini.');
        }

        // Save token and user data to session
        $sessionData = [
            'jwt_token' => $response['data']['token'],
            'user_id' => $response['data']['user']['id'],
            'username' => $response['data']['user']['username'],
            'email' => $response['data']['user']['email'],
            'nama_lengkap' => $response['data']['user']['nama_lengkap'],
            'role' => $response['data']['user']['roles']['name'],
            'is_logged_in' => true,
        ];

        session()->set($sessionData);

        // Redirect to dashboard
        return redirect()->to('/admin/dashboard')
            ->with('success', 'Login berhasil! Selamat datang, ' . $response['data']['user']['nama_lengkap']);
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
