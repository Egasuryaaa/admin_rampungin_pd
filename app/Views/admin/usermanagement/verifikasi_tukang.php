<?php include APPPATH . 'Views/templates/header.php'; ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Verifikasi Tukang</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Verifikasi Tukang</li>
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
                    <?php if (!empty($tukang) && is_array($tukang)): ?>
                        <?php foreach ($tukang as $t): ?>
                            <div class="col-lg-6 col-md-12 mb-4">
                                <div class="card stretch stretch-full">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <?= esc($t['nama_lengkap'] ?? 'N/A') ?>
                                            <span class="badge bg-warning ms-2">Menunggu Verifikasi</span>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">Email</label>
                                                <p class="mb-0"><?= esc($t['email'] ?? 'N/A') ?></p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">Username</label>
                                                <p class="mb-0">@<?= esc($t['username'] ?? 'N/A') ?></p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">No Telepon</label>
                                                <p class="mb-0"><?= esc($t['no_telp'] ?? '-') ?></p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">Kota</label>
                                                <p class="mb-0"><?= esc($t['kota'] ?? '-') ?></p>
                                            </div>
                                        </div>

                                        <?php if (!empty($t['profil_tukang'])): ?>
                                            <hr>
                                            <h6 class="mb-3">Profil Tukang</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">Pengalaman</label>
                                                    <p class="mb-0"><?= esc($t['profil_tukang']['pengalaman_tahun'] ?? 0) ?> Tahun</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small">Tarif per Jam</label>
                                                    <p class="mb-0">Rp <?= number_format($t['profil_tukang']['tarif_per_jam'] ?? 0, 0, ',', '.') ?></p>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="text-muted small">Bio</label>
                                                    <p class="mb-0"><?= esc($t['profil_tukang']['bio'] ?? '-') ?></p>
                                                </div>
                                            </div>

                                            <h6 class="mb-3">Informasi Bank</h6>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="text-muted small">Nama Bank</label>
                                                    <p class="mb-0"><?= esc($t['profil_tukang']['nama_bank'] ?? '-') ?></p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="text-muted small">Nomor Rekening</label>
                                                    <p class="mb-0"><?= esc($t['profil_tukang']['nomor_rekening'] ?? '-') ?></p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="text-muted small">Nama Pemilik</label>
                                                    <p class="mb-0"><?= esc($t['profil_tukang']['nama_pemilik_rekening'] ?? '-') ?></p>
                                                </div>
                                            </div>

                                            <?php if (!empty($t['profil_tukang']['kategori_tukang'])): ?>
                                                <h6 class="mb-3">Kategori Keahlian</h6>
                                                <div class="mb-3">
                                                    <?php foreach ($t['profil_tukang']['kategori_tukang'] as $kategori): ?>
                                                        <span class="badge bg-primary me-1 mb-1">
                                                            <?= esc($kategori['kategori']['nama'] ?? 'N/A') ?>
                                                        </span>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <div class="d-flex gap-2 mt-4">
                                            <button type="button" class="btn btn-success flex-fill" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#approveModal<?= $t['id_user'] ?? $t['id'] ?>">
                                                <i class="feather-check"></i> Setujui Verifikasi
                                            </button>
                                            <button type="button" class="btn btn-danger flex-fill" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#rejectModal<?= $t['id_user'] ?? $t['id'] ?>">
                                                <i class="feather-x"></i> Tolak Verifikasi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="feather-info"></i> Tidak ada tukang yang menunggu verifikasi.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($pagination) && $pagination['total_pages'] > 1): ?>
                    <div class="row">
                        <div class="col-12">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
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
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Verification Modals Section -->
        <?php if (!empty($tukang)): ?>
            <?php foreach ($tukang as $t): ?>
                <!-- Approve Modal -->
                <div class="modal fade" id="approveModal<?= $t['id_user'] ?? $t['id'] ?>" tabindex="-1" aria-labelledby="approveModalLabel<?= $t['id_user'] ?? $t['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="<?= base_url('admin/users/verifications/tukang/' . ($t['id_user'] ?? $t['id'])) ?>" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="approve">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="approveModalLabel<?= $t['id_user'] ?? $t['id'] ?>">Setujui Verifikasi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Yakin ingin menyetujui verifikasi tukang <strong><?= esc($t['nama_lengkap'] ?? 'N/A') ?></strong>?</p>
                                    <div class="alert alert-info">
                                        <i class="feather-info"></i> Tukang akan dapat menerima pesanan setelah diverifikasi.
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Setujui</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Reject Modal -->
                <div class="modal fade" id="rejectModal<?= $t['id_user'] ?? $t['id'] ?>" tabindex="-1" aria-labelledby="rejectModalLabel<?= $t['id_user'] ?? $t['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="<?= base_url('admin/users/verifications/tukang/' . ($t['id_user'] ?? $t['id'])) ?>" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="reject">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="rejectModalLabel<?= $t['id_user'] ?? $t['id'] ?>">Tolak Verifikasi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Tolak verifikasi tukang <strong><?= esc($t['nama_lengkap'] ?? 'N/A') ?></strong>?</p>
                                    <div class="mb-3">
                                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="alasan_penolakan" rows="4" required 
                                                  placeholder="Jelaskan alasan penolakan verifikasi"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

<?php include APPPATH . 'Views/templates/footer.php'; ?>
