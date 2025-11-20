<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Debug logging (hapus setelah testing)
        log_message('debug', '=== AdminAuthFilter START ===');
        log_message('debug', 'Current URI: ' . uri_string());
        log_message('debug', 'Current URL: ' . current_url());
        log_message('debug', 'Session isLoggedIn: ' . (session()->get('isLoggedIn') ? 'YES' : 'NO'));
        log_message('debug', 'Session ses_userId: ' . (session()->get('ses_userId') ?? 'NULL'));
        log_message('debug', 'Session ses_roleId: ' . (session()->get('ses_roleId') ?? 'NULL'));

        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            log_message('debug', 'AdminAuthFilter: Not logged in, redirecting to /login');
            
            // Simpan URL tujuan untuk redirect setelah login
            session()->set('redirect_url', current_url());
            
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek apakah user adalah admin (role_id = 1)
        $roleId = session()->get('ses_roleId');
        if (!$roleId || (int)$roleId !== 1) {
            log_message('warning', 'AdminAuthFilter: Non-admin user (role: ' . $roleId . ') trying to access admin area');
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Akses ditolak. Hanya admin yang diizinkan.');
        }

        log_message('debug', 'AdminAuthFilter: Authentication passed');
        log_message('debug', '=== AdminAuthFilter END ===');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do after
    }
}