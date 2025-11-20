<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Debug logging
        log_message('debug', '=== AdminAuthFilter START ===');
        log_message('debug', 'Current URI: ' . uri_string());
        log_message('debug', 'JWT Token exists: ' . ($session->has('jwt_token') ? 'YES' : 'NO'));
        log_message('debug', 'Is Logged In: ' . ($session->get('is_logged_in') ? 'YES' : 'NO'));
        log_message('debug', 'User Role: ' . ($session->get('role') ?? 'NULL'));

        // Check if user is logged in with JWT token
        if (!$session->has('jwt_token') || !$session->get('is_logged_in')) {
            log_message('debug', 'AdminAuthFilter: Not logged in, redirecting to /auth/login');
            
            // Save target URL for redirect after login
            $session->set('redirect_url', current_url());
            
            return redirect()->to('/auth/login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        // Check if user role is 'admin'
        $role = $session->get('role');
        if (!$role || $role !== 'admin') {
            log_message('warning', 'AdminAuthFilter: Non-admin user (role: ' . $role . ') trying to access admin area');
            $session->destroy();
            return redirect()->to('/auth/login')
                ->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }

        log_message('debug', 'AdminAuthFilter: Authentication passed for user: ' . $session->get('username'));
        log_message('debug', '=== AdminAuthFilter END ===');
        
        // Allow request to continue
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do after request
        return $response;
    }
}