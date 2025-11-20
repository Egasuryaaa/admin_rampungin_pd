<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ApiService;

class DashboardController extends BaseController
{
    protected $apiService;

    public function __construct()
    {
        $this->apiService = new ApiService();
    }

    /**
     * Display admin dashboard with statistics
     */
    public function index()
    {
        // Fetch dashboard statistics from API
        $response = $this->apiService->get('/api/admin/dashboard');

        // Check if token expired (401)
        if (isset($response['http_code']) && $response['http_code'] === 401) {
            return redirect()->to('/auth/login')
                ->with('error', 'Session expired. Please login again.');
        }

        // Check if request failed
        if (!$response['success']) {
            $data = [
                'error' => true,
                'message' => $response['message'] ?? 'Gagal mengambil data dashboard',
                'stats' => null,
            ];
            return view('admin/dashboard', $data);
        }

        // Prepare data for view
        $data = [
            'error' => false,
            'stats' => $response['data'],
            'user_name' => session()->get('nama_lengkap'),
            'page_title' => 'Dashboard',
        ];

        return view('admin/dashboard', $data);
    }

    /**
     * Get dashboard statistics (AJAX endpoint)
     */
    public function getStats()
    {
        $response = $this->apiService->get('/api/admin/dashboard');

        // Return JSON response
        return $this->response->setJSON($response);
    }

    /**
     * Get recent activities (optional - if you want to add this feature)
     */
    public function getRecentActivities()
    {
        // Fetch recent transactions
        $response = $this->apiService->get('/api/admin/transactions', [
            'limit' => 10,
            'page' => 1,
        ]);

        if (!$response['success']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengambil data aktivitas',
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $response['data']['transactions'] ?? [],
        ]);
    }
}
