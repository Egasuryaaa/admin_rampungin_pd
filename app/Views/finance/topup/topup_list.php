<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="theme_ocean" />
    
    <title>Permintaan Topup - Admin Tukang</title>
    <?php if (!function_exists('base_url')) { helper('url'); } ?>
    <base href="<?= base_url() ?>">
    
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/daterangepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/dataTables.bs5.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <?php include APPPATH . 'Views/templates/navbar.php'; ?>

    <header class="nxl-header">
        <div class="header-wrapper">
            <div class="header-left d-flex align-items-center gap-4">
                <a href="javascript:void(0);" class="nxl-head-mobile-toggler" id="mobile-collapse">
                    <div class="hamburger hamburger--arrowturn">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>
                </a>
                <div class="nxl-navigation-toggle">
                    <a href="javascript:void(0);" id="menu-mini-button">
                        <i class="feather-align-left"></i>
                    </a>
                    <a href="javascript:void(0);" id="menu-expend-button" style="display: none">
                        <i class="feather-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="header-right ms-auto">
                <div class="d-flex align-items-center">
                    <div class="dropdown nxl-h-item nxl-header-search">
                        <a href="javascript:void(0);" class="nxl-head-link me-0" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="feather-search"></i>
                        </a>
                    </div>
                    <div class="nxl-h-item d-none d-sm-flex">
                        <div class="full-screen-switcher">
                            <a href="javascript:void(0);" class="nxl-head-link me-0" onclick="$('body').fullScreenHelper('toggle');">
                                <i class="feather-maximize maximize"></i>
                                <i class="feather-minimize minimize"></i>
                            </a>
                        </div>
                    </div>
                    <div class="nxl-h-item dark-light-theme">
                        <a href="javascript:void(0);" class="nxl-head-link me-0 dark-button">
                            <i class="feather-moon"></i>
                        </a>
                        <a href="javascript:void(0);" class="nxl-head-link me-0 light-button" style="display: none">
                            <i class="feather-sun"></i>
                        </a>
                    </div>
                    <div class="dropdown nxl-h-item">
                        <a class="nxl-head-link me-3" data-bs-toggle="dropdown" href="#" role="button" data-bs-auto-close="outside">
                            <i class="feather-bell"></i>
                            <span class="badge bg-danger nxl-h-badge" id="notification-badge">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-notifications-dropdown" id="notification-dropdown">
                            <div class="dropdown-header">
                                <div class="d-flex align-items-center">
                                    <h6 class="text-dark mb-0">Notifikasi Topup Pending</h6>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="nxl-scrollable" style="max-height: 280px;">
                                <!-- Notification items will be inserted here by JavaScript -->
                                <div id="notification-list"></div>
                            </div>
                            <div class="dropdown-footer">
                                <a href="wallet-transaksi/topup" class="text-dark">
                                    <span class="fs-12 fw-bold">Lihat Semua Topup</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown nxl-h-item">
                        <a href="javascript:void(0);" data-bs-toggle="dropdown" role="button" data-bs-auto-close="outside">
                            <img src="assets/images/avatar/1.png" alt="user-image" class="img-fluid user-avtar me-0" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-user-dropdown">
                            <div class="dropdown-header">
                                <div class="d-flex align-items-center">
                                    <img src="assets/images/avatar/1.png" alt="user-image" class="img-fluid user-avtar" />
                                    <div>
                                        <h6 class="text-dark mb-0">
                                            <?= esc(session()->get('nama_lengkap') ?? session()->get('user')['username'] ?? 'Admin') ?>
                                            <span class="badge bg-soft-success text-success ms-1">PRO</span>
                                        </h6>
                                        <span class="fs-12 fw-medium text-muted">
                                            <?= esc(session()->get('email') ?? session()->get('user')['email'] ?? 'email@example.com') ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="feather-user"></i>
                                <span>Profile Details</span>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="feather-settings"></i>
                                <span>Account Settings</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('logout') ?>" class="dropdown-item">
                                <i class="feather-log-out"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Permintaan Topup</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Wallet & Transaksi</a></li>
                        <li class="breadcrumb-item">Topup</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                </div>
            </div>

            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body p-0">
                                <!-- Flash Messages -->
                                <?php if (session()->getFlashdata('success')): ?>
                                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                        <?= session()->getFlashdata('success') ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (session()->getFlashdata('error')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                                        <?= session()->getFlashdata('error') ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <div class="table-responsive">
                                    <table class="table table-hover" id="topupList">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User</th>
                                                <th>Jumlah</th>
                                                <th>Metode Bayar</th>
                                                <th>Status</th>
                                                <th>Tgl. Topup</th>
                                                <th>Tgl. Verifikasi</th>
                                                <th>Tgl. Kadaluarsa</th>
                                                <th>Diverifikasi Oleh</th>
                                                <th>Alasan Penolakan</th>
                                                <th class="text-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($topups) && !empty($topups)): ?>
                                                <?php foreach ($topups as $tp): ?>
                                                <tr>
                                                    <td><?= esc($tp['id'] ?? '') ?></td>
                                                    <td>
                                                        <a href="<?= base_url('usermanagement/view/' . ($tp['user_id'] ?? '')) ?>">
                                                            <?= esc($tp['nama_lengkap'] ?? $tp['username'] ?? ('User ' . $tp['user_id'])) ?>
                                                        </a>
                                                    </td>
                                                    <td><strong><?= esc(isset($tp['jumlah']) ? 'Rp ' . number_format($tp['jumlah'], 0, ',', '.') : 'Rp 0') ?></strong></td>
                                                    <td><?= esc(strtoupper($tp['metode_pembayaran'] ?? '-')) ?></td>
                                                    <td>
                                                        <?php
                                                            $status = $tp['status'] ?? 'pending';
                                                            $badgeClass = 'secondary';
                                                            if ($status == 'pending') $badgeClass = 'warning';
                                                            if ($status == 'berhasil' || $status == 'selesai') $badgeClass = 'success';
                                                            if ($status == 'ditolak' || $status == 'gagal') $badgeClass = 'danger';
                                                            if ($status == 'kadaluarsa') $badgeClass = 'secondary';
                                                        ?>
                                                        <span class="badge bg-soft-<?= $badgeClass ?> text-<?= $badgeClass ?>"><?= esc(ucfirst($status)) ?></span>
                                                    </td>
                                                    <td><?= esc(isset($tp['created_at']) ? date('d/m/Y H:i', strtotime($tp['created_at'])) : '-') ?></td>
                                                    <td><?= esc(isset($tp['waktu_verifikasi']) ? date('d/m/Y H:i', strtotime($tp['waktu_verifikasi'])) : '-') ?></td>
                                                    <td><?= esc(isset($tp['kadaluarsa_pada']) ? date('d/m/Y H:i', strtotime($tp['kadaluarsa_pada'])) : '-') ?></td>
                                                    <td><?= esc($tp['admin_nama'] ?? '-') ?></td>
                                                    <td><?= esc($tp['alasan_penolakan'] ?? '-') ?></td>
                                                    <td class="text-end">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <?php if (!empty($tp['bukti_pembayaran'])): ?>
                                                                <a href="<?= base_url($tp['bukti_pembayaran']) ?>" target="_blank" 
                                                                   class="avatar-text avatar-md text-info" data-bs-toggle="tooltip" title="Lihat Bukti Pembayaran">
                                                                    <i class="feather-file-text"></i>
                                                                </a>
                                                            <?php else: ?>
                                                                <a href="#" class="avatar-text avatar-md text-muted" data-bs-toggle="tooltip" title="Tidak ada bukti" style="cursor: not-allowed;">
                                                                    <i class="feather-file-text"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            
                                                            <?php if (($tp['status'] ?? '') == 'pending'): ?>
                                                                <a href="<?= base_url('wallet-transaksi/topup-verifikasi/' . ($tp['id'] ?? '')) ?>" 
                                                                   class="avatar-text avatar-md text-primary" data-bs-toggle="tooltip" title="Verifikasi Topup">
                                                                    <i class="feather-check-square"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="11" class="text-center py-5">
                                                        <div class="text-muted">
                                                            <i class="feather-inbox fs-1 mb-3"></i>
                                                            <p class="mb-0">Tidak ada data permintaan topup.</p>
                                                        </div>
                                                    </td>
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

        <footer class="footer">
            <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
                <span>Copyright ©</span>
                <script>document.write(new Date().getFullYear());</script>
            </p>
            <div class="d-flex align-items-center gap-4">
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Help</a>
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Terms</a>
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Privacy</a>
            </div>
        </footer>
    </main>
    
    <script src="assets/vendors/js/vendors.min.js"></script>
    <script src="assets/vendors/js/dataTables.min.js"></script>
    <script src="assets/vendors/js/dataTables.bs5.min.js"></script>
    <script src="assets/vendors/js/daterangepicker.min.js"></script>
    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/theme-customizer-init.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize DataTable
            $('#topupList').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                }
            });

            function fetchNotifications() {
                $.ajax({
                    url: '<?= base_url('notifications/pending-topups') ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status && response.data.length > 0) {
                            // Update badge
                            $('#notification-badge').text(response.data.length).removeClass('d-none');

                            // Clear existing notifications
                            $('#notification-list').empty();

                            // Populate notification list
                            $.each(response.data, function(index, topup) {
                                var notificationItem = `
                                    <a href="<?= base_url('wallet-transaksi/topup-verifikasi/') ?>${topup.id}" class="dropdown-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-sm">
                                                    <span class="avatar-text bg-primary text-white">
                                                        <i class="feather-dollar-sign"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="fs-14 mb-0">
                                                    <strong>Topup baru dari ${topup.username}</strong>
                                                </p>
                                                <p class="fs-12 text-muted mb-0">
                                                    Rp ${new Intl.NumberFormat('id-ID').format(topup.jumlah)} - ${topup.created_at_human}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                `;
                                $('#notification-list').append(notificationItem);
                            });
                        } else {
                            $('#notification-badge').text('0').addClass('d-none');
                            $('#notification-list').html('<p class="text-center text-muted fs-12 my-3">Tidak ada notifikasi baru.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Gagal mengambil notifikasi:", error);
                        // Optionally show an error message in the dropdown
                        $('#notification-list').html('<p class="text-center text-danger fs-12 my-3">Gagal memuat notifikasi.</p>');
                    }
                });
            }

            // Fetch notifications on page load
            fetchNotifications();

            // Optionally, refresh notifications every 1 minute
            setInterval(fetchNotifications, 60000);
        });
    </script>
</body>

</html>