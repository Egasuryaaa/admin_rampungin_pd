<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ApiService;

class UserManagementController extends BaseController
{
    protected $apiService;

    public function __construct()
    {
        $this->apiService = new ApiService();
    }

    /**
     * ========================================
     * USER LISTING
     * ========================================
     */

    /**
     * Display all users with filters
     */
    public function index()
    {
        $filters = [
            'role' => $this->request->getGet('role'),
            'is_active' => $this->request->getGet('is_active'),
            'is_verified' => $this->request->getGet('is_verified'),
            'search' => $this->request->getGet('search'),
            'page' => $this->request->getGet('page') ?? 1,
            'limit' => $this->request->getGet('limit') ?? 20,
        ];

        // Remove null values
        $filters = array_filter($filters, function($value) {
            return $value !== null && $value !== '';
        });

        // Fetch users from API
        $response = $this->apiService->get('/api/admin/users', $filters);

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Prepare data for view
        $pagination = $response['data']['pagination'] ?? null;
        if (!$pagination || !isset($pagination['current_page'])) {
            $pagination = [
                'current_page' => 1,
                'total_pages' => 1,
                'total_items' => 0,
                'per_page' => 20
            ];
        }
        
        $data = [
            'page_title' => 'Manajemen User',
            'users' => $response['data']['users'] ?? [],
            'pagination' => $pagination,
            'filters' => $filters,
            'error' => !$response['success'],
            'message' => $response['message'] ?? null,
        ];

        return view('admin/usermanagement/users_list', $data);
    }

    /**
     * Display list of clients only
     */
    public function clients()
    {
        $filters = [
            'role' => 'client',
            'is_active' => $this->request->getGet('is_active'),
            'search' => $this->request->getGet('search'),
            'page' => $this->request->getGet('page') ?? 1,
            'limit' => $this->request->getGet('limit') ?? 20,
        ];

        // Remove null values
        $filters = array_filter($filters, function($value) {
            return $value !== null && $value !== '';
        });

        // Fetch clients from API
        $response = $this->apiService->get('/api/admin/users', $filters);

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Prepare data for view
        $pagination = $response['data']['pagination'] ?? null;
        if (!$pagination || !isset($pagination['current_page'])) {
            $pagination = [
                'current_page' => 1,
                'total_pages' => 1,
                'total_items' => 0,
                'per_page' => 20
            ];
        }
        
        $data = [
            'page_title' => 'Daftar User (Client)',
            'users' => $response['data']['users'] ?? [],
            'pagination' => $pagination,
            'filters' => $filters,
            'error' => !$response['success'],
            'message' => $response['message'] ?? null,
        ];

        return view('admin/usermanagement/users_list', $data);
    }

    /**
     * Display list of tukang (workers)
     */
    public function tukang()
    {
        $filters = [
            'role' => 'tukang',
            'is_active' => $this->request->getGet('is_active'),
            'is_verified' => $this->request->getGet('is_verified'),
            'search' => $this->request->getGet('search'),
            'page' => $this->request->getGet('page') ?? 1,
            'limit' => $this->request->getGet('limit') ?? 20,
        ];

        // Remove null values
        $filters = array_filter($filters, function($value) {
            return $value !== null && $value !== '';
        });

        // Fetch tukang from API
        $response = $this->apiService->get('/api/admin/users', $filters);

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Prepare data for view
        $pagination = $response['data']['pagination'] ?? null;
        if (!$pagination || !isset($pagination['current_page'])) {
            $pagination = [
                'current_page' => 1,
                'total_pages' => 1,
                'total_items' => 0,
                'per_page' => 20
            ];
        }
        
        $data = [
            'page_title' => 'Daftar Tukang',
            'users' => $response['data']['users'] ?? [],
            'pagination' => $pagination,
            'filters' => $filters,
            'error' => !$response['success'],
            'message' => $response['message'] ?? null,
        ];

        return view('admin/usermanagement/users_list', $data);
    }

    /**
     * ========================================
     * USER STATUS MANAGEMENT
     * ========================================
     */

    /**
     * Update user status (Ban/Unban)
     * 
     * @param int $id User ID
     */
    public function updateStatus($id)
    {
        $is_active = $this->request->getPost('is_active');

        // Validate input
        if ($is_active === null) {
            return redirect()->back()
                ->with('error', 'Status tidak valid');
        }

        // Convert to boolean
        $is_active = filter_var($is_active, FILTER_VALIDATE_BOOLEAN);

        // Send update request to API
        $response = $this->apiService->put(
            "/api/admin/users/{$id}/status",
            ['is_active' => $is_active]
        );

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Prepare message
        $message = $is_active 
            ? 'User berhasil diaktifkan kembali'
            : 'User berhasil dinonaktifkan (banned)';

        // Redirect with message
        if ($response['success']) {
            return redirect()->back()
                ->with('success', $message);
        } else {
            return redirect()->back()
                ->with('error', $response['message'] ?? 'Gagal mengubah status user');
        }
    }

    /**
     * Ban user (shortcut method)
     * 
     * @param int $id User ID
     */
    public function banUser($id)
    {
        $response = $this->apiService->put(
            "/api/admin/users/{$id}/status",
            ['is_active' => false]
        );

        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        if ($response['success']) {
            return redirect()->back()
                ->with('success', 'User berhasil di-ban');
        } else {
            return redirect()->back()
                ->with('error', $response['message'] ?? 'Gagal mem-ban user');
        }
    }

    /**
     * Unban user (shortcut method)
     * 
     * @param int $id User ID
     */
    public function unbanUser($id)
    {
        $response = $this->apiService->put(
            "/api/admin/users/{$id}/status",
            ['is_active' => true]
        );

        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        if ($response['success']) {
            return redirect()->back()
                ->with('success', 'User berhasil di-unban');
        } else {
            return redirect()->back()
                ->with('error', $response['message'] ?? 'Gagal meng-unban user');
        }
    }

    /**
     * ========================================
     * TUKANG VERIFICATION
     * ========================================
     */

    /**
     * Display unverified tukang
     */
    public function unverifiedTukang()
    {
        $page = $this->request->getGet('page') ?? 1;
        $limit = $this->request->getGet('limit') ?? 20;

        // Fetch unverified tukang from API
        $response = $this->apiService->get('/api/admin/verifications/tukang', [
            'page' => $page,
            'limit' => $limit,
        ]);

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Prepare data for view
        $data = [
            'page_title' => 'Verifikasi Tukang',
            'tukang' => $response['data']['tukang'] ?? [],
            'pagination' => $response['data']['pagination'] ?? [
                'current_page' => 1,
                'total_pages' => 1,
                'total_items' => 0,
                'per_page' => 20
            ],
            'error' => !$response['success'],
            'message' => $response['message'] ?? null,
        ];

        return view('admin/usermanagement/verifikasi_tukang', $data);
    }

    /**
     * Verify tukang (Approve/Reject)
     * 
     * @param int $id Tukang user ID
     */
    public function verifyTukang($id)
    {
        $action = $this->request->getPost('action'); // 'approve' or 'reject'

        // Validate action
        if (!in_array($action, ['approve', 'reject'])) {
            return redirect()->back()
                ->with('error', 'Aksi tidak valid');
        }

        // Send verification request to API
        $response = $this->apiService->put(
            "/api/admin/verifications/tukang/{$id}",
            ['action' => $action]
        );

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Prepare message
        $message = $action === 'approve' 
            ? 'Tukang berhasil diverifikasi. Sekarang dapat menerima pesanan.'
            : 'Pendaftaran tukang ditolak.';

        // Redirect with message
        if ($response['success']) {
            return redirect()->back()
                ->with('success', $message);
        } else {
            return redirect()->back()
                ->with('error', $response['message'] ?? 'Gagal memverifikasi tukang');
        }
    }

    /**
     * Get user detail (AJAX)
     * 
     * @param int $id User ID
     */
    public function getUserDetail($id)
    {
        $response = $this->apiService->get("/api/admin/users/{$id}");

        return $this->response->setJSON($response);
    }
}
