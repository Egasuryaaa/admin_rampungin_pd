<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="theme_ocean" />
    
    <title>Permintaan Penarikan - Admin Tukang</title>
    <?php if (!function_exists('base_url')) { helper('url'); } ?>
    <base href="<?= base_url() ?>">
    
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/daterangepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
       <!-- NAVIGATION & HEADER sama seperti sebelumnya, tidak ada perubahan -->
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
                            <span class="badge bg-danger nxl-h-badge">3</span> </a>
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
                                        <h6 class="text-dark mb-0"><?= esc($user['username'] ?? 'Admin') ?> <span class="badge bg-soft-success text-success ms-1">PRO</span></h6>
                                        <span class="fs-12 fw-medium text-muted"><?= esc($user['email'] ?? 'email@example.com') ?></span>
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
                            <a href="<?= site_url('logout') ?>" class="dropdown-item"> <i class="feather-log-out"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header> 

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
                            <span class="badge bg-danger nxl-h-badge">3</span> </a>
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
                                        <h6 class="text-dark mb-0"><?= esc($user['username'] ?? 'Admin') ?> <span class="badge bg-soft-success text-success ms-1">PRO</span></h6>
                                        <span class="fs-12 fw-medium text-muted"><?= esc($user['email'] ?? 'email@example.com') ?></span>
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
                            <a href="<?= site_url('logout') ?>" class="dropdown-item"> <i class="feather-log-out"></i>
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
                        <h5 class="m-b-10">Permintaan Penarikan</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Wallet & Transaksi</a></li>
                        <li class="breadcrumb-item">Withdraw (Tarik Tunai)</li>
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
                                <div class="table-responsive">
                                    <table class="table table-hover" id="withdrawList">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tukang</th>
                                                <th>Tujuan Transfer</th>
                                                <th>Jml. Diminta</th>
                                                <th>Biaya Admin</th>
                                                <th>Jml. Bersih</th>
                                                <th>Status</th>
                                                <th>Tgl. Dibuat</th>
                                                <th>Tgl. Diproses</th>
                                                <th>Diproses Oleh</th>
                                                <th>Alasan Penolakan</th>
                                                <th class="text-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($withdrawals) && !empty($withdrawals)): ?>
                                                <?php foreach ($withdrawals as $wd): ?>
                                                <tr>
                                                    <td><?= esc($wd['id'] ?? '') ?></td>
                                                    <td>
                                                        <a href="<?= base_url('usermanagement/view/' . ($wd['tukang_id'] ?? '')) ?>">
                                                            <?= esc($wd['nama_lengkap'] ?? $wd['username'] ?? ('User ' . $wd['tukang_id'])) ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <strong><?= esc(strtoupper($wd['nama_bank'] ?? '-')) ?></strong><br>
                                                        <?= esc($wd['nomor_rekening'] ?? '-') ?><br>
                                                        (a.n. <?= esc($wd['nama_pemilik_rekening'] ?? '-') ?>)
                                                    </td>
                                                    <td><?= esc(isset($wd['jumlah']) ? 'Rp ' . number_format($wd['jumlah'], 0, ',', '.') : 'Rp 0') ?></td>
                                                    <td><?= esc(isset($wd['biaya_admin']) ? 'Rp ' . number_format($wd['biaya_admin'], 0, ',', '.') : 'Rp 0') ?></td>
                                                    <td>
                                                        <strong><?= esc(isset($wd['jumlah_bersih']) ? 'Rp ' . number_format($wd['jumlah_bersih'], 0, ',', '.') : 'Rp 0') ?></strong>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $status = $wd['status'] ?? 'pending';
                                                            $badgeClass = 'secondary'; // Default
                                                            if ($status == 'pending') $badgeClass = 'warning';
                                                            if ($status == 'diproses') $badgeClass = 'primary';
                                                            if ($status == 'selesai') $badgeClass = 'success';
                                                            if ($status == 'ditolak') $badgeClass = 'danger';
                                                        ?>
                                                        <span class="badge bg-soft-<?= $badgeClass ?> text-<?= $badgeClass ?>"><?= esc(ucfirst($status)) ?></span>
                                                    </td>
                                                    <td><?= esc(isset($wd['created_at']) ? date('d/m/Y H:i', strtotime($wd['created_at'])) : '-') ?></td>
                                                    
                                                    <td><?= esc(isset($wd['waktu_diproses']) ? date('d/m/Y H:i', strtotime($wd['waktu_diproses'])) : '-') ?></td>
                                                    <td><?= esc($wd['admin_nama'] ?? '-') ?></td>
                                                    <td><?= esc($wd['alasan_penolakan'] ?? '-') ?></td>

                                                    <td class="text-end">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <a href="<?= base_url('wallet-transaksi/withdraw-view/' . ($wd['id'] ?? '')) ?>" 
                                                               class="avatar-text avatar-md" data-bs-toggle="tooltip" title="Lihat Detail">
                                                                <i class="feather-eye"></i>
                                                            </a>
                                                            
                                                            <?php if (($wd['status'] ?? '') == 'pending'): ?>
                                                                <a href="<?= base_url('wallet-transaksi/withdraw-proses/' . ($wd['id'] ?? '')) ?>" 
                                                                   class="avatar-text avatar-md text-primary" data-bs-toggle="tooltip" title="Proses Penarikan">
                                                                    <i class="feather-edit"></i>
                                                                </a>
                                                            <?php endif; ?>

                                                            <?php if (($wd['status'] ?? '') == 'diproses' || ($wd['status'] ?? '') == 'selesai'): ?>
                                                                <a href="<?= base_url($wd['bukti_transfer'] ?? '#') ?>" target="_blank" 
                                                                   class="avatar-text avatar-md text-info" data-bs-toggle="tooltip" title="Lihat Bukti Transfer">
                                                                    <i class="feather-file-text"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="12" class="text-center py-5">
                                                        <div class="text-muted">
                                                            <i class="feather-inbox fs-1 mb-3"></i>
                                                            <p class="mb-0">Tidak ada data permintaan penarikan.</p>
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
    <script src="assets/vendors/js/daterangepicker.min.js"></script>
    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/theme-customizer-init.min.js"></script>

    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</body>

</html>