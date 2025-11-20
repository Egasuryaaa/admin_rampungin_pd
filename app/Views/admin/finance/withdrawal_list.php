<?php include APPPATH . 'Views/templates/header.php'; ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Kelola Penarikan</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Penarikan</li>
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
                            <div class="card-body custom-card-action p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="withdrawalTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User</th>
                                                <th>Jumlah</th>
                                                <th>Bank</th>
                                                <th>No Rekening</th>
                                                <th>Nama Pemilik</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($withdrawal_list) && is_array($withdrawal_list)): ?>
                                                <?php foreach ($withdrawal_list as $withdrawal): ?>
                                                    <tr>
                                                        <td><?= esc($withdrawal['id_penarikan'] ?? $withdrawal['id']) ?></td>
                                                        <td>
                                                            <strong><?= esc($withdrawal['user']['nama_lengkap'] ?? 'N/A') ?></strong><br>
                                                            <small class="text-muted"><?= esc($withdrawal['user']['email'] ?? '') ?></small>
                                                        </td>
                                                        <td><strong>Rp <?= number_format($withdrawal['jumlah_penarikan'] ?? 0, 0, ',', '.') ?></strong></td>
                                                        <td><?= esc($withdrawal['nama_bank'] ?? 'N/A') ?></td>
                                                        <td><?= esc($withdrawal['nomor_rekening'] ?? 'N/A') ?></td>
                                                        <td><?= esc($withdrawal['nama_pemilik_rekening'] ?? 'N/A') ?></td>
                                                        <td>
                                                            <?php
                                                            $status = $withdrawal['status'] ?? 'pending';
                                                            $badgeClass = [
                                                                'pending' => 'warning',
                                                                'confirmed' => 'success',
                                                                'rejected' => 'danger'
                                                            ][$status] ?? 'secondary';
                                                            ?>
                                                            <span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                                                        </td>
                                                        <td><?= date('d M Y H:i', strtotime($withdrawal['tanggal_penarikan'] ?? 'now')) ?></td>
                                                        <td>
                                                            <?php if ($status === 'pending'): ?>
                                                                <button type="button" class="btn btn-sm btn-success" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#confirmModal<?= $withdrawal['id_penarikan'] ?? $withdrawal['id'] ?>">
                                                                    <i class="feather-check"></i> Konfirmasi
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-danger" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#rejectModal<?= $withdrawal['id_penarikan'] ?? $withdrawal['id'] ?>">
                                                                    <i class="feather-x"></i> Tolak
                                                                </button>
                                                            <?php else: ?>
                                                                <span class="text-muted">-</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">Tidak ada data penarikan</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <?php if (!empty($pagination)): ?>
                                <div class="card-footer">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center mb-0">
                                            <li class="page-item <?= ($pagination['current_page'] <= 1) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="?page=<?= $pagination['current_page'] - 1 ?>">Previous</a>
                                            </li>
                                            <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                                                <li class="page-item <?= ($i == $pagination['current_page']) ? 'active' : '' ?>">
                                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>
                                            <li class="page-item <?= ($pagination['current_page'] >= $pagination['total_pages']) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="?page=<?= $pagination['current_page'] + 1 ?>">Next</a>
                                            </li>
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
        
        <!-- Withdrawal Modals Section -->
        <?php if (!empty($withdrawal_list)): ?>
            <?php foreach ($withdrawal_list as $withdrawal): ?>
                <?php if ($withdrawal['status'] == 'pending'): ?>
                    <!-- Confirm Modal -->
                    <div class="modal fade" id="confirmModal<?= $withdrawal['id_penarikan'] ?? $withdrawal['id'] ?>" tabindex="-1" aria-labelledby="confirmModalLabel<?= $withdrawal['id_penarikan'] ?? $withdrawal['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="<?= base_url('admin/finance/withdrawal/confirm/' . ($withdrawal['id_penarikan'] ?? $withdrawal['id'])) ?>" 
                                      method="POST" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmModalLabel<?= $withdrawal['id_penarikan'] ?? $withdrawal['id'] ?>">Konfirmasi Penarikan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Konfirmasi penarikan sebesar <strong>Rp <?= number_format($withdrawal['jumlah_penarikan'] ?? 0, 0, ',', '.') ?></strong>?</p>
                                        <div class="mb-3">
                                            <label class="form-label">Upload Bukti Transfer <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" name="bukti_transfer" 
                                                   accept="image/*,application/pdf" required>
                                            <small class="text-muted">Format: JPG, PNG, PDF (Max 5MB)</small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Catatan (Opsional)</label>
                                            <textarea class="form-control" name="catatan" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">Konfirmasi Transfer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Reject Modal -->
                    <div class="modal fade" id="rejectModal<?= $withdrawal['id_penarikan'] ?? $withdrawal['id'] ?>" tabindex="-1" aria-labelledby="rejectModalLabel<?= $withdrawal['id_penarikan'] ?? $withdrawal['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="<?= base_url('admin/finance/withdrawal/reject/' . ($withdrawal['id_penarikan'] ?? $withdrawal['id'])) ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectModalLabel<?= $withdrawal['id_penarikan'] ?? $withdrawal['id'] ?>">Tolak Penarikan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Tolak penarikan sebesar <strong>Rp <?= number_format($withdrawal['jumlah_penarikan'] ?? 0, 0, ',', '.') ?></strong>?</p>
                                        <div class="alert alert-info">
                                            <i class="feather-info"></i> Poin akan dikembalikan ke user
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="alasan_penolakan" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Tolak Penarikan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

<?php include APPPATH . 'Views/templates/footer.php'; ?>
