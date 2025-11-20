<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ApiService;

class FinanceController extends BaseController
{
    protected $apiService;

    public function __construct()
    {
        $this->apiService = new ApiService();
    }

    /**
     * ========================================
     * TOPUP MANAGEMENT
     * ========================================
     */

    /**
     * Display list of pending topup requests
     */
    public function topup()
    {
        $page = $this->request->getGet('page') ?? 1;
        $limit = $this->request->getGet('limit') ?? 20;

        // Fetch pending topup from API
        $response = $this->apiService->get('/api/admin/finance/topup', [
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
            'page_title' => 'Manajemen Top-Up',
            'topup_list' => $response['data']['topup'] ?? [],
            'pagination' => $response['data']['pagination'] ?? null,
            'error' => !$response['success'],
            'message' => $response['message'] ?? null,
        ];

        return view('admin/finance/topup_list', $data);
    }

    /**
     * Verify topup (Approve or Reject)
     * 
     * @param int $id Topup ID
     */
    public function verifyTopup($id)
    {
        $action = $this->request->getPost('action'); // 'approve' or 'reject'
        $alasan_penolakan = $this->request->getPost('alasan_penolakan');

        // Validate action
        if (!in_array($action, ['approve', 'reject'])) {
            return redirect()->back()
                ->with('error', 'Aksi tidak valid');
        }

        // Validate rejection reason if rejecting
        if ($action === 'reject' && empty($alasan_penolakan)) {
            return redirect()->back()
                ->with('error', 'Alasan penolakan harus diisi');
        }

        // Prepare request data
        $requestData = ['action' => $action];
        if ($action === 'reject') {
            $requestData['alasan_penolakan'] = $alasan_penolakan;
        }

        // Send verification request to API
        $response = $this->apiService->put("/api/admin/finance/topup/{$id}", $requestData);

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Prepare message
        $message = $action === 'approve' 
            ? 'Top-up berhasil disetujui. Poin user telah ditambahkan.'
            : 'Top-up berhasil ditolak.';

        // Redirect with message
        if ($response['success']) {
            return redirect()->to('/admin/finance/topup')
                ->with('success', $message);
        } else {
            return redirect()->back()
                ->with('error', $response['message'] ?? 'Gagal memproses top-up');
        }
    }

    /**
     * ========================================
     * WITHDRAWAL MANAGEMENT
     * ========================================
     */

    /**
     * Display list of pending withdrawal requests
     */
    public function withdrawal()
    {
        $page = $this->request->getGet('page') ?? 1;
        $limit = $this->request->getGet('limit') ?? 20;

        // Fetch pending withdrawal from API
        $response = $this->apiService->get('/api/admin/finance/withdrawal', [
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
            'page_title' => 'Manajemen Penarikan Dana',
            'withdrawal_list' => $response['data']['withdrawal'] ?? [],
            'pagination' => $response['data']['pagination'] ?? null,
            'error' => !$response['success'],
            'message' => $response['message'] ?? null,
        ];

        return view('admin/finance/withdrawal_list', $data);
    }

    /**
     * Confirm withdrawal (Approve with proof)
     * 
     * @param int $id Withdrawal ID
     */
    public function confirmWithdrawal($id)
    {
        // Validate file upload
        $validationRule = [
            'bukti_transfer' => [
                'rules' => 'uploaded[bukti_transfer]|max_size[bukti_transfer,2048]|ext_in[bukti_transfer,jpg,jpeg,png,pdf]',
                'errors' => [
                    'uploaded' => 'Bukti transfer harus diupload',
                    'max_size' => 'Ukuran file maksimal 2MB',
                    'ext_in' => 'File harus berformat JPG, JPEG, PNG, atau PDF',
                ],
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        // Get uploaded file
        $file = $this->request->getFile('bukti_transfer');

        if (!$file->isValid()) {
            return redirect()->back()
                ->with('error', 'File tidak valid: ' . $file->getErrorString());
        }

        // Send confirmation request to API with file
        $response = $this->apiService->put(
            "/api/admin/finance/withdrawal/{$id}/confirm",
            [],
            ['bukti_transfer' => $file]
        );

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Redirect with message
        if ($response['success']) {
            return redirect()->to('/admin/finance/withdrawal')
                ->with('success', 'Penarikan dana berhasil dikonfirmasi. Bukti transfer telah disimpan.');
        } else {
            return redirect()->back()
                ->with('error', $response['message'] ?? 'Gagal memproses penarikan dana');
        }
    }

    /**
     * Reject withdrawal (Refund poin)
     * 
     * @param int $id Withdrawal ID
     */
    public function rejectWithdrawal($id)
    {
        $alasan_penolakan = $this->request->getPost('alasan_penolakan');

        // Validate rejection reason
        if (empty($alasan_penolakan)) {
            return redirect()->back()
                ->with('error', 'Alasan penolakan harus diisi');
        }

        // Send rejection request to API
        $response = $this->apiService->put(
            "/api/admin/finance/withdrawal/{$id}/reject",
            ['alasan_penolakan' => $alasan_penolakan]
        );

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Redirect with message
        if ($response['success']) {
            return redirect()->to('/admin/finance/withdrawal')
                ->with('success', 'Penarikan dana ditolak. Poin telah dikembalikan ke tukang.');
        } else {
            return redirect()->back()
                ->with('error', $response['message'] ?? 'Gagal menolak penarikan dana');
        }
    }

    /**
     * Get withdrawal detail (AJAX)
     * 
     * @param int $id Withdrawal ID
     */
    public function getWithdrawalDetail($id)
    {
        $response = $this->apiService->get("/api/admin/finance/withdrawal/{$id}");

        return $this->response->setJSON($response);
    }

    /**
     * Get topup detail (AJAX)
     * 
     * @param int $id Topup ID
     */
    public function getTopupDetail($id)
    {
        $response = $this->apiService->get("/api/admin/finance/topup/{$id}");

        return $this->response->setJSON($response);
    }
}
