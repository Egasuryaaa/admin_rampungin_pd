<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ApiService;

class CategoryController extends BaseController
{
    protected $apiService;

    public function __construct()
    {
        $this->apiService = new ApiService();
    }

    /**
     * Display list of categories
     */
    public function index()
    {
        $filters = [
            'is_active' => $this->request->getGet('is_active'),
            'search' => $this->request->getGet('search'),
        ];

        // Remove null values
        $filters = array_filter($filters, function($value) {
            return $value !== null && $value !== '';
        });

        // Fetch categories from API
        $response = $this->apiService->get('/api/admin/categories', $filters);

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Prepare data for view
        $data = [
            'page_title' => 'Manajemen Kategori',
            'categories' => $response['data'] ?? [],
            'filters' => $filters,
            'error' => !$response['success'],
            'message' => $response['message'] ?? null,
        ];

        return view('admin/categories/index', $data);
    }

    /**
     * Show create category form
     */
    public function create()
    {
        $data = [
            'page_title' => 'Tambah Kategori',
        ];

        return view('admin/categories/create', $data);
    }

    /**
     * Store new category
     */
    public function store()
    {
        // Validate input
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'deskripsi' => 'permit_empty|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Prepare data
        $categoryData = [
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        // Send request to API
        $response = $this->apiService->post('/api/admin/categories', $categoryData);

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Redirect with message
        if ($response['success']) {
            return redirect()->to('/admin/categories')
                ->with('success', 'Kategori berhasil ditambahkan');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', $response['message'] ?? 'Gagal menambahkan kategori');
        }
    }

    /**
     * Show edit category form
     * 
     * @param int $id Category ID
     */
    public function edit($id)
    {
        // Fetch category detail
        $response = $this->apiService->get("/api/admin/categories/{$id}");

        if (!$response['success']) {
            return redirect()->to('/admin/categories')
                ->with('error', 'Kategori tidak ditemukan');
        }

        $data = [
            'page_title' => 'Edit Kategori',
            'category' => $response['data'],
        ];

        return view('admin/categories/edit', $data);
    }

    /**
     * Update category
     * 
     * @param int $id Category ID
     */
    public function update($id)
    {
        // Validate input
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'deskripsi' => 'permit_empty|max_length[500]',
            'is_active' => 'required|in_list[0,1,true,false]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Prepare data
        $categoryData = [
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'is_active' => filter_var($this->request->getPost('is_active'), FILTER_VALIDATE_BOOLEAN),
        ];

        // Send update request to API
        $response = $this->apiService->put("/api/admin/categories/{$id}", $categoryData);

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Redirect with message
        if ($response['success']) {
            return redirect()->to('/admin/categories')
                ->with('success', 'Kategori berhasil diupdate');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', $response['message'] ?? 'Gagal mengupdate kategori');
        }
    }

    /**
     * Delete category (soft delete)
     * 
     * @param int $id Category ID
     */
    public function delete($id)
    {
        // Send delete request to API
        $response = $this->apiService->delete("/api/admin/categories/{$id}");

        // Check for errors
        if (isset($response['redirect'])) {
            return redirect()->to($response['redirect'])
                ->with('error', $response['message']);
        }

        // Redirect with message
        if ($response['success']) {
            return redirect()->to('/admin/categories')
                ->with('success', 'Kategori berhasil dihapus (soft delete)');
        } else {
            return redirect()->back()
                ->with('error', $response['message'] ?? 'Gagal menghapus kategori');
        }
    }
}
