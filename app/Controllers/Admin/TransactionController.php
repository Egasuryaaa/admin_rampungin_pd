<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ApiService;

class TransactionController extends BaseController
{
    protected $apiService;

    public function __construct()
    {
        $this->apiService = new ApiService();
    }

    /**
     * Display list of transactions with filters
     */
    public function index()
    {
        $filters = [
            'status' => $this->request->getGet('status'),
            'metode_pembayaran' => $this->request->getGet('metode_pembayaran'),
            'search' => $this->request->getGet('search'),
            'start_date' => $this->request->getGet('start_date'),
            'end_date' => $this->request->getGet('end_date'),
            'page' => $this->request->getGet('page') ?? 1,
            'limit' => $this->request->getGet('limit') ?? 20,
        ];

        // Remove null values
        $filters = array_filter($filters, function($value) {
            return $value !== null && $value !== '';
        });

        // Fetch transactions from API
        $response = $this->apiService->get('/api/admin/transactions', $filters);

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Prepare data for view
        $data = [
            'page_title' => 'Monitoring Transaksi',
            'transactions' => $response['data']['transactions'] ?? [],
            'pagination' => $response['data']['pagination'] ?? null,
            'filters' => $filters,
            'error' => !$response['success'],
            'message' => $response['message'] ?? null,
        ];

        return view('admin/transactions/index', $data);
    }

    /**
     * Display transaction detail
     * 
     * @param int $id Transaction ID
     */
    public function detail($id)
    {
        // Fetch transaction detail from API
        $response = $this->apiService->get("/api/admin/transactions/{$id}");

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        if (!$response['success']) {
            return redirect()->to('/admin/transactions')
                ->with('error', 'Transaksi tidak ditemukan');
        }

        // Prepare data for view
        $data = [
            'page_title' => 'Detail Transaksi',
            'transaction' => $response['data'],
        ];

        return view('admin/transactions/detail', $data);
    }

    /**
     * Get transaction statistics (AJAX)
     */
    public function getStats()
    {
        $filters = [
            'start_date' => $this->request->getGet('start_date'),
            'end_date' => $this->request->getGet('end_date'),
        ];

        // Remove null values
        $filters = array_filter($filters, function($value) {
            return $value !== null && $value !== '';
        });

        // Fetch transaction stats
        $response = $this->apiService->get('/api/admin/transactions/stats', $filters);

        return $this->response->setJSON($response);
    }

    /**
     * Export transactions to CSV (if API supports it)
     */
    public function export()
    {
        $filters = [
            'status' => $this->request->getGet('status'),
            'metode_pembayaran' => $this->request->getGet('metode_pembayaran'),
            'start_date' => $this->request->getGet('start_date'),
            'end_date' => $this->request->getGet('end_date'),
        ];

        // Remove null values
        $filters = array_filter($filters, function($value) {
            return $value !== null && $value !== '';
        });

        // Fetch all transactions (without pagination)
        $response = $this->apiService->get('/api/admin/transactions', array_merge($filters, [
            'page' => 1,
            'limit' => 10000, // Large limit for export
        ]));

        if (!$response['success']) {
            return redirect()->back()
                ->with('error', 'Gagal mengekspor data transaksi');
        }

        $transactions = $response['data']['transactions'] ?? [];

        // Generate CSV
        $filename = 'transactions_' . date('Y-m-d_His') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // CSV Headers
        fputcsv($output, [
            'No Pesanan',
            'Tanggal',
            'Client',
            'Tukang',
            'Kategori',
            'Judul Layanan',
            'Lokasi',
            'Total Biaya',
            'Metode Pembayaran',
            'Status',
            'Rating'
        ]);

        // CSV Data
        foreach ($transactions as $transaction) {
            fputcsv($output, [
                $transaction['nomor_pesanan'] ?? '-',
                $transaction['created_at'] ?? '-',
                $transaction['users_transaksi_client_idTousers']['nama_lengkap'] ?? '-',
                $transaction['users_transaksi_tukang_idTousers']['nama_lengkap'] ?? '-',
                $transaction['kategori']['nama'] ?? '-',
                $transaction['judul_layanan'] ?? '-',
                $transaction['lokasi_kerja'] ?? '-',
                $transaction['total_biaya'] ?? '0',
                $transaction['metode_pembayaran'] ?? '-',
                $transaction['status'] ?? '-',
                $transaction['rating']['rating'] ?? '-'
            ]);
        }

        fclose($output);
        exit;
    }
}
