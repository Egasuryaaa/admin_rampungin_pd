<?php include APPPATH . 'Views/templates/header.php'; ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10"><?= esc($page_title ?? 'Kelola Top-Up') ?></h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Keuangan</a></li>
                        <li class="breadcrumb-item">Top-Up</li>
                    </ul>
                </div>
            </div>

            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <!-- Filter Status Tabs -->
                            <div class="card-header">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($current_status ?? 'pending') === 'pending' ? 'active' : '' ?>" 
                                           href="<?= base_url('admin/finance/topup?status=pending') ?>">
                                            <i class="feather-clock"></i> Pending
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($current_status ?? '') === 'berhasil' ? 'active' : '' ?>" 
                                           href="<?= base_url('admin/finance/topup?status=berhasil') ?>">
                                            <i class="feather-check-circle"></i> Berhasil
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($current_status ?? '') === 'ditolak' ? 'active' : '' ?>" 
                                           href="<?= base_url('admin/finance/topup?status=ditolak') ?>">
                                            <i class="feather-x-circle"></i> Ditolak
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($current_status ?? '') === 'kadaluarsa' ? 'active' : '' ?>" 
                                           href="<?= base_url('admin/finance/topup?status=kadaluarsa') ?>">
                                            <i class="feather-clock"></i> Kadaluarsa
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="card-body p-0">
                                <!-- Flash Messages -->
                                <?php if (session()->getFlashdata('success')): ?>
                                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                        <?= session()->getFlashdata('success') ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (session()->getFlashdata('error')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                                        <?= session()->getFlashdata('error') ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-danger m-3">
                                        <i class="feather-alert-circle"></i>
                                        <?= esc($message ?? 'Gagal mengambil data top-up') ?>
                                    </div>
                                <?php endif; ?>

                                <div class="table-responsive">
                                    <table class="table table-hover" id="topupList">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User</th>
                                                <th>Jumlah</th>
                                                <th>Metode</th>
                                                <th>Status</th>
                                                <th>Tanggal Dibuat</th>
                                                <th>Diverifikasi Oleh</th>
                                                <th>Bukti</th>
                                                <th class="text-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($topup_list) && !empty($topup_list)): ?>
                                                <?php foreach ($topup_list as $topup): ?>
                                                <tr>
                                                    <td><?= esc($topup['id']) ?></td>
                                                    <td>
                                                        <strong><?= esc($topup['users_topup_user_idTousers']['nama_lengkap'] ?? $topup['users_topup_user_idTousers']['username'] ?? 'N/A') ?></strong><br>
                                                        <small class="text-muted"><?= esc($topup['users_topup_user_idTousers']['email'] ?? '') ?></small>
                                                    </td>
                                                    <td><strong class="text-success">Rp <?= number_format($topup['jumlah'], 0, ',', '.') ?></strong></td>
                                                    <td><span class="badge bg-info"><?= esc(strtoupper($topup['metode_pembayaran'])) ?></span></td>
                                                    <td>
                                                        <?php
                                                            $status = $topup['status'];
                                                            $badgeClass = 'secondary';
                                                            $statusLabel = ucfirst($status);
                                                            
                                                            if ($status == 'pending') {
                                                                $badgeClass = 'warning';
                                                                $statusLabel = 'Pending';
                                                            } elseif ($status == 'berhasil') {
                                                                $badgeClass = 'success';
                                                                $statusLabel = 'Berhasil';
                                                            } elseif ($status == 'ditolak') {
                                                                $badgeClass = 'danger';
                                                                $statusLabel = 'Ditolak';
                                                            } elseif ($status == 'kadaluarsa') {
                                                                $badgeClass = 'secondary';
                                                                $statusLabel = 'Kadaluarsa';
                                                            }
                                                        ?>
                                                        <span class="badge bg-<?= $badgeClass ?>"><?= $statusLabel ?></span>
                                                    </td>
                                                    <td><?= date('d M Y H:i', strtotime($topup['created_at'])) ?></td>
                                                    <td>
                                                        <?php if (!empty($topup['diverifikasi_oleh']) && !empty($topup['waktu_verifikasi'])): ?>
                                                            <small class="text-muted">
                                                                Admin ID: <?= esc($topup['diverifikasi_oleh']) ?><br>
                                                                <?= date('d M Y H:i', strtotime($topup['waktu_verifikasi'])) ?>
                                                            </small>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($topup['bukti_pembayaran'])): ?>
                                                            <a href="<?= base_url($topup['bukti_pembayaran']) ?>" target="_blank" class="btn btn-sm btn-light-brand">
                                                                <i class="feather-file-text"></i> Lihat
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-end">
                                                        <?php if ($topup['status'] == 'pending'): ?>
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <form action="<?= base_url('admin/finance/topup/verify/' . $topup['id']) ?>" method="POST" class="d-inline">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="action" value="approve">
                                                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui top-up ini?')">
                                                                        <i class="feather-check"></i> Approve
                                                                    </button>
                                                                </form>
                                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal<?= $topup['id'] ?>">
                                                                    <i class="feather-x"></i> Reject
                                                                </button>
                                                            </div>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="8" class="text-center py-5">
                                                        <div class="text-muted">
                                                            <i class="feather-inbox fs-1 mb-3"></i>
                                                            <p class="mb-0">Tidak ada data top-up.</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
                                <div class="card-footer">
                                    <nav>
                                        <ul class="pagination justify-content-center mb-0">
                                            <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                                                <li class="page-item <?= $i == $pagination['page'] ? 'active' : '' ?>">
                                                    <a class="page-link" href="?status=<?= esc($current_status ?? 'pending') ?>&page=<?= $i ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>
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
    </main>
    
    <!-- Reject Modals Section -->
    <?php if (!empty($topup_list)): ?>
        <?php foreach ($topup_list as $topup): ?>
            <?php if ($topup['status'] == 'pending'): ?>
                <div class="modal fade" id="rejectModal<?= $topup['id'] ?>" tabindex="-1" aria-labelledby="rejectModalLabel<?= $topup['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="<?= base_url('admin/finance/topup/verify/' . $topup['id']) ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="reject">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectModalLabel<?= $topup['id'] ?>">Tolak Top-Up</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                            <textarea name="alasan_penolakan" class="form-control" rows="3" required placeholder="Masukkan alasan penolakan..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Tolak Top-Up</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

<?php include APPPATH . 'Views/templates/footer.php'; ?>
