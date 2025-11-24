<?php include APPPATH . 'Views/templates/header.php'; ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Manajemen User</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">User Management</li>
                    </ul>
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
                            <div class="card-header">
                                <h5 class="card-title">Daftar User</h5>
                                <div class="card-header-action">
                                    <form method="GET" class="d-flex gap-2">
                                        <select name="role" class="form-select form-select-sm" style="width: 150px;">
                                            <option value="">Semua Role</option>
                                            <option value="client" <?= (isset($_GET['role']) && $_GET['role'] === 'client') ? 'selected' : '' ?>>Client</option>
                                            <option value="tukang" <?= (isset($_GET['role']) && $_GET['role'] === 'tukang') ? 'selected' : '' ?>>Tukang</option>
                                        </select>
                                        <select name="is_active" class="form-select form-select-sm" style="width: 150px;">
                                            <option value="">Semua Status</option>
                                            <option value="true" <?= (isset($_GET['is_active']) && $_GET['is_active'] === 'true') ? 'selected' : '' ?>>Aktif</option>
                                            <option value="false" <?= (isset($_GET['is_active']) && $_GET['is_active'] === 'false') ? 'selected' : '' ?>>Banned</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body custom-card-action p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="usersTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User</th>
                                                <th>Role</th>
                                                <th>No Telp</th>
                                                <th>Kota</th>
                                                <th>Poin</th>
                                                <th>Status</th>
                                                <th>Verifikasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($users) && is_array($users)): ?>
                                                <?php foreach ($users as $user): ?>
                                                    <tr>
                                                        <td><?= esc($user['id_user'] ?? $user['id']) ?></td>
                                                        <td>
                                                            <strong><?= esc($user['nama_lengkap'] ?? 'N/A') ?></strong><br>
                                                            <small class="text-muted"><?= esc($user['email'] ?? '') ?></small><br>
                                                            <small class="text-muted">@<?= esc($user['username'] ?? '') ?></small>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $role = $user['role'] ?? 'client';
                                                            $roleClass = [
                                                                'admin' => 'danger',
                                                                'tukang' => 'primary',
                                                                'client' => 'info'
                                                            ][$role] ?? 'secondary';
                                                            ?>
                                                            <span class="badge bg-<?= $roleClass ?>"><?= ucfirst($role) ?></span>
                                                        </td>
                                                        <td><?= esc($user['no_telp'] ?? '-') ?></td>
                                                        <td><?= esc($user['kota'] ?? '-') ?></td>
                                                        <td><strong><?= number_format($user['poin'] ?? 0, 0, ',', '.') ?></strong></td>
                                                        <td>
                                                            <?php $isActive = $user['is_active'] ?? true; ?>
                                                            <span class="badge bg-<?= $isActive ? 'success' : 'danger' ?>">
                                                                <?= $isActive ? 'Aktif' : 'Banned' ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <?php $isVerified = $user['is_verified'] ?? false; ?>
                                                            <span class="badge bg-<?= $isVerified ? 'success' : 'warning' ?>">
                                                                <?= $isVerified ? 'Terverifikasi' : 'Belum Verifikasi' ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <?php if ($isActive): ?>
                                                                <form action="<?= base_url('admin/users/ban/' . ($user['id_user'] ?? $user['id'])) ?>" 
                                                                      method="POST" class="d-inline" 
                                                                      onsubmit="return confirm('Yakin ingin memban user ini?')">
                                                                    <?= csrf_field() ?>
                                                                    <button type="submit" class="btn btn-sm btn-danger" title="Ban User">
                                                                        <i class="feather-slash"></i> Ban
                                                                    </button>
                                                                </form>
                                                            <?php else: ?>
                                                                <form action="<?= base_url('admin/users/unban/' . ($user['id_user'] ?? $user['id'])) ?>" 
                                                                      method="POST" class="d-inline"
                                                                      onsubmit="return confirm('Yakin ingin unban user ini?')">
                                                                    <?= csrf_field() ?>
                                                                    <button type="submit" class="btn btn-sm btn-success" title="Unban User">
                                                                        <i class="feather-check"></i> Unban
                                                                    </button>
                                                                </form>
                                                            <?php endif; ?>
                                                            <a href="<?= base_url('admin/users/detail/' . ($user['id_user'] ?? $user['id'])) ?>" 
                                                               class="btn btn-sm btn-info" title="Detail User">
                                                                <i class="feather-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">Tidak ada data user</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <?php if (!empty($pagination) && $pagination['total_pages'] > 1): ?>
                                <div class="card-footer">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center mb-0">
                                            <?php if ($pagination['current_page'] > 1): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="?page=<?= $pagination['current_page'] - 1 ?><?= isset($_GET['role']) ? '&role=' . $_GET['role'] : '' ?><?= isset($_GET['is_active']) ? '&is_active=' . $_GET['is_active'] : '' ?>">Previous</a>
                                                </li>
                                            <?php else: ?>
                                                <li class="page-item disabled">
                                                    <span class="page-link" style="color: #6c757d; background-color: #fff; border-color: #dee2e6;">Previous</span>
                                                </li>
                                            <?php endif; ?>
                                            
                                            <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                                                <li class="page-item <?= ($i == $pagination['current_page']) ? 'active' : '' ?>">
                                                    <a class="page-link" href="?page=<?= $i ?><?= isset($_GET['role']) ? '&role=' . $_GET['role'] : '' ?><?= isset($_GET['is_active']) ? '&is_active=' . $_GET['is_active'] : '' ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>
                                            
                                            <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="?page=<?= $pagination['current_page'] + 1 ?><?= isset($_GET['role']) ? '&role=' . $_GET['role'] : '' ?><?= isset($_GET['is_active']) ? '&is_active=' . $_GET['is_active'] : '' ?>">Next</a>
                                                </li>
                                            <?php else: ?>
                                                <li class="page-item disabled">
                                                    <span class="page-link" style="color: #6c757d; background-color: #fff; border-color: #dee2e6;">Next</span>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </nav>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php include APPPATH . 'Views/templates/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": false
        });
    });
</script>
