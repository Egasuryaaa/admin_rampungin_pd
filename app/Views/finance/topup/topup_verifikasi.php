<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verifikasi Topup - Admin Tukang</title>
    
    <?php if (!function_exists('base_url')) { helper('url'); } ?>
    <base href="<?= base_url() ?>">

    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <style>
        .payment-proof-container {
            max-height: 500px;
            overflow: hidden;
            border-radius: .5rem;
            border: 1px solid #eee;
        }
        .payment-proof-container img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <?php include APPPATH . 'Views/templates/navbar.php'; ?>

    <header class="nxl-header">
        <div class="header-wrapper">
            <div class="header-left d-flex align-items-center gap-4">
                <a href="javascript:void(0);" class="nxl-head-mobile-toggler" id="mobile-collapse">
                    <div class="hamburger hamburger--arrowturn">
                        <div class="hamburger-box"><div class="hamburger-inner"></div></div>
                    </div>
                </a>
            </div>
            <div class="header-right ms-auto">
                <div class="d-flex align-items-center">
                    <!-- Header Icons -->
                </div>
            </div>
        </div>
    </header>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Verifikasi Topup</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('wallet-transaksi/topup') ?>">Topup</a></li>
                        <li class="breadcrumb-item">Verifikasi</li>
                    </ul>
                </div>
            </div>

            <div class="main-content">
                <div class="row">
                    <!-- Kolom Kiri: Detail Transaksi -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Detail Permintaan Topup</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold" style="width: 200px;">ID Transaksi</td>
                                                <td>: <?= esc($topup['id']) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Nama User</td>
                                                <td>: <a href="<?= site_url('usermanagement/view/' . $topup['user_id']) ?>"><?= esc($topup['nama_lengkap']) ?></a></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Email</td>
                                                <td>: <?= esc($topup['email']) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">No. Telepon</td>
                                                <td>: <?= esc($topup['no_telp']) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Jumlah Topup</td>
                                                <td>: <strong class="text-primary fs-5">Rp <?= number_format($topup['jumlah'], 0, ',', '.') ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Metode Pembayaran</td>
                                                <td>: <?= esc(strtoupper($topup['metode_pembayaran'])) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Tanggal Permintaan</td>
                                                <td>: <?= date('d F Y, H:i', strtotime($topup['created_at'])) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Status Saat Ini</td>
                                                <td>: <span class="badge bg-soft-warning text-warning"><?= esc(ucfirst($topup['status'])) ?></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Bukti & Form Aksi -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Bukti Pembayaran & Aksi</h5>
                            </div>
                            <div class="card-body">
                                <!-- Flash Messages -->
                                <?php if (session()->getFlashdata('error')): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= session()->getFlashdata('error') ?>
                                    </div>
                                <?php endif; ?>

                                <h6 class="mb-3">Bukti Pembayaran</h6>
                                <div class="payment-proof-container mb-4">
                                    <a href="<?= base_url($topup['bukti_pembayaran']) ?>" target="_blank">
                                        <img src="<?= base_url($topup['bukti_pembayaran']) ?>" alt="Bukti Pembayaran">
                                    </a>
                                </div>

                                <form action="<?= site_url('wallet-transaksi/topup-verifikasi-action') ?>" method="POST" id="verification-form">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="topup_id" value="<?= esc($topup['id']) ?>">
                                    <input type="hidden" name="status" id="status-input" value="">

                                    <div class="mb-3" id="alasan-penolakan-container" style="display: none;">
                                        <label for="alasan_penolakan" class="form-label">Alasan Penolakan</label>
                                        <textarea name="alasan_penolakan" id="alasan_penolakan" class="form-control" rows="3" placeholder="Contoh: Bukti transfer tidak valid atau tidak sesuai."></textarea>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <div id="rejection-actions" style="display: none;">
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-danger w-75">Kirim Penolakan</button>
                                                <button type="button" class="btn btn-secondary w-25" id="btn-back">Kembali</button>
                                            </div>
                                        </div>
                                        <div class="btn-group" role="group" id="action-buttons">
                                            <button type="button" class="btn btn-success w-50" id="btn-approve">
                                                <i class="feather-check-circle me-2"></i>Setujui
                                            </button>
                                            <button type="button" class="btn btn-danger w-50" id="btn-reject">
                                                <i class="feather-x-circle me-2"></i>Tolak
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
                <span>Copyright ©</span> <script>document.write(new Date().getFullYear());</script>
            </p>
        </footer>
    </main>
    
    <script src="assets/vendors/js/vendors.min.js"></script>
    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/theme-customizer-init.min.js"></script>

    <script>
        $(document).ready(function() {
            const form = $('#verification-form');
            const statusInput = $('#status-input');
            const alasanContainer = $('#alasan-penolakan-container');
            const alasanTextarea = $('#alasan_penolakan');
            const btnApprove = $('#btn-approve');
            const btnReject = $('#btn-reject');
            const actionButtons = $('#action-buttons');
            const rejectionActions = $('#rejection-actions');
            const btnBack = $('#btn-back');
            const btnSubmitRejection = $('#rejection-actions button[type="submit"]');

            btnApprove.on('click', function() {
                if (confirm('Apakah Anda yakin ingin menyetujui top-up ini?')) {
                    statusInput.val('disetujui');
                    alasanContainer.hide();
                    alasanTextarea.prop('required', false);
                    form.submit();
                }
            });

            btnReject.on('click', function() {
                statusInput.val('ditolak');
                alasanContainer.show();
                alasanTextarea.prop('required', true);
                actionButtons.hide();
                rejectionActions.show();
            });

            btnBack.on('click', function() {
                statusInput.val('');
                alasanContainer.hide();
                alasanTextarea.prop('required', false).val('').removeClass('is-invalid');
                rejectionActions.hide();
                actionButtons.show();
            });

            btnSubmitRejection.on('click', function(e) {
                e.preventDefault(); 
                if (alasanTextarea.val().trim() === '') {
                    alasanTextarea.addClass('is-invalid');
                    if (alasanTextarea.next('.invalid-feedback').length === 0) {
                        alasanTextarea.after('<div class="invalid-feedback">Alasan penolakan tidak boleh kosong.</div>');
                    }
                } else {
                    if (confirm('Apakah Anda yakin ingin menolak top-up ini?')) {
                        form.submit();
                    }
                }
            });
        });
    </script>
</body>

</html>