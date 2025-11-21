<?php include APPPATH . 'Views/templates/header.php'; ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Manajemen Kategori</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Kategori</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                        <i class="feather-plus"></i> Tambah Kategori
                    </button>
                </div>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body custom-card-action p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="categoriesTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama Kategori</th>
                                                <th>Deskripsi</th>
                                                <th>Status</th>
                                                <th>Dibuat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($categories) && is_array($categories)): ?>
                                                <?php foreach ($categories as $category): ?>
                                                    <tr>
                                                        <td><?= esc($category['id_kategori'] ?? $category['id']) ?></td>
                                                        <td><strong><?= esc($category['nama'] ?? 'N/A') ?></strong></td>
                                                        <td><?= esc($category['deskripsi'] ?? '-') ?></td>
                                                        <td>
                                                            <?php $isActive = $category['is_active'] ?? true; ?>
                                                            <span class="badge bg-<?= $isActive ? 'success' : 'secondary' ?>">
                                                                <?= $isActive ? 'Aktif' : 'Nonaktif' ?>
                                                            </span>
                                                        </td>
                                                        <td><?= date('d M Y', strtotime($category['created_at'] ?? 'now')) ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-warning" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#editCategoryModal<?= $category['id_kategori'] ?? $category['id'] ?>">
                                                                <i class="feather-edit"></i> Edit
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-danger" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#deleteCategoryModal<?= $category['id_kategori'] ?? $category['id'] ?>">
                                                                <i class="feather-trash"></i> Hapus
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data kategori</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Section - Placed outside main container -->
    <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $category): ?>
                    <!-- Edit Modal for <?= esc($category['nama'] ?? 'N/A') ?> -->
                <div class="modal fade" id="editCategoryModal<?= $category['id_kategori'] ?? $category['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $category['id_kategori'] ?? $category['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="<?= base_url('admin/categories/update/' . ($category['id_kategori'] ?? $category['id'])) ?>" method="POST">
                                <?= csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?= $category['id_kategori'] ?? $category['id'] ?>">Edit Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama" value="<?= esc($category['nama'] ?? '') ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea class="form-control" name="deskripsi" rows="3"><?= esc($category['deskripsi'] ?? '') ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_active" value="true" 
                                                   <?= ($category['is_active'] ?? true) ? 'checked' : '' ?>>
                                            <label class="form-check-label">Aktif</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Update Kategori</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal for <?= esc($category['nama'] ?? 'N/A') ?> -->
                <div class="modal fade" id="deleteCategoryModal<?= $category['id_kategori'] ?? $category['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $category['id_kategori'] ?? $category['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="<?= base_url('admin/categories/delete/' . ($category['id_kategori'] ?? $category['id'])) ?>" method="POST">
                                <?= csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel<?= $category['id_kategori'] ?? $category['id'] ?>">Hapus Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger">
                                        <i class="feather-alert-triangle"></i> 
                                        <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                                    </div>
                                    <p>Yakin ingin menghapus kategori <strong><?= esc($category['nama'] ?? 'N/A') ?></strong>?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Hapus Kategori</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
    <?php endif; ?>

    <!-- Create Category Modal -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= base_url('admin/categories/create') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCategoryModalLabel">Tambah Kategori Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" required 
                                   placeholder="Contoh: Tukang Listrik">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3" 
                                      placeholder="Deskripsi kategori..."></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="true" checked>
                                <label class="form-check-label">Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include APPPATH . 'Views/templates/footer.php'; ?>
