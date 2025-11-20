<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="theme_ocean" />
    
    <title>Wallet Tukang - Admin Tukang</title>
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
                            <span class="badge bg-danger nxl-h-badge">3</span>
                        </a>
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
                                        <h6 class="text-dark mb-0"><?= session()->get('nama_lengkap') ?? 'Admin' ?> <span class="badge bg-soft-success text-success ms-1">PRO</span></h6>
                                        <span class="fs-12 fw-medium text-muted"><?= session()->get('email') ?? 'email@example.com' ?></span>
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
                        <h5 class="m-b-10">Wallet Tukang</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Wallet & Transaksi</a></li>
                        <li class="breadcrumb-item">Wallet Tukang</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="d-flex align-items-center gap-2">
                        <div class="dropdown">
                            <button class="btn btn-light-brand dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="feather-filter me-2"></i>
                                <span>Filter Status</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?status=all">Semua Status</a></li>
                                <li><a class="dropdown-item" href="?status=active">Aktif</a></li>
                                <li><a class="dropdown-item" href="?status=inactive">Tidak Aktif</a></li>
                                <li><a class="dropdown-item" href="?status=unverified">Belum Verifikasi</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-light-brand" onclick="exportData()">
                            <i class="feather-download me-2"></i>
                            <span>Export</span>
                        </button>
                        <button type="button" class="btn btn-primary" onclick="location.reload()">
                            <i class="feather-refresh-cw me-2"></i>
                            <span>Refresh</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="main-content">
                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-xxl-3 col-sm-6">
                        <div class="card nxl-widget">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-sm nxl-widget-icon bg-success">
                                        <i class="feather-users"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0 text-success">
                                            <?= esc(isset($total_tukang) ? number_format($total_tukang, 0, ',', '.') : '0') ?>
                                        </h5>
                                        <span class="fs-12 fw-medium text-muted">Total Tukang</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="badge bg-soft-success text-success">
                                        <i class="feather-check fs-10"></i>
                                        <span>Aktif</span>
                                    </div>
                                    <p class="mb-0 text-muted text-truncate">Tukang terdaftar</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-sm-6">
                        <div class="card nxl-widget">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-sm nxl-widget-icon bg-warning">
                                        <i class="feather-clock"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0 text-warning">
                                            <?= esc(isset($total_penarikan_pending) ? number_format($total_penarikan_pending, 0, ',', '.') : '0') ?>
                                        </h5>
                                        <span class="fs-12 fw-medium text-muted">Penarikan Pending</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="badge bg-soft-warning text-warning">
                                        <i class="feather-alert-circle fs-10"></i>
                                        <span>Menunggu</span>
                                    </div>
                                    <p class="mb-0 text-muted text-truncate">Perlu diproses</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-sm-6">
                        <div class="card nxl-widget">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-sm nxl-widget-icon bg-info">
                                        <i class="feather-trending-up"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0 text-info">
                                            <?= esc(isset($total_penarikan_diproses) ? number_format($total_penarikan_diproses, 0, ',', '.') : '0') ?>
                                        </h5>
                                        <span class="fs-12 fw-medium text-muted">Sedang Diproses</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="badge bg-soft-info text-info">
                                        <i class="feather-loader fs-10"></i>
                                        <span>Proses</span>
                                    </div>
                                    <p class="mb-0 text-muted text-truncate">Dalam pengerjaan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-sm-6">
                        <div class="card nxl-widget">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-sm nxl-widget-icon bg-primary">
                                        <i class="feather-check-circle"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0 text-primary">
                                            <?= esc(isset($total_penarikan_selesai) ? number_format($total_penarikan_selesai, 0, ',', '.') : '0') ?>
                                        </h5>
                                        <span class="fs-12 fw-medium text-muted">Penarikan Selesai</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="badge bg-soft-primary text-primary">
                                        <i class="feather-thumbs-up fs-10"></i>
                                        <span>Selesai</span>
                                    </div>
                                    <p class="mb-0 text-muted text-truncate">Bulan ini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wallet Table -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Daftar Tukang</h5>
                                <div class="card-header-action">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" placeholder="Cari tukang..." id="searchWallet">
                                        <button class="btn btn-sm btn-light-brand" type="button">
                                            <i class="feather-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="walletList">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Tukang</th>
                                                <th>Lokasi</th>
                                                <th class="text-center">Rating</th>
                                                <th class="text-center">Poin</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($wallets) && !empty($wallets)): ?>
                                                <?php $no = 1; ?>
                                                <?php foreach ($wallets as $wallet): ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-image avatar-sm me-3">
                                                                <?php 
                                                                $fotoPath = $wallet['foto_profil'] ?? '';
                                                                $fotoExists = !empty($fotoPath) && file_exists(FCPATH . $fotoPath);
                                                                ?>
                                                                <?php if ($fotoExists): ?>
                                                                    <img src="<?= base_url(esc($fotoPath)) ?>" alt="" class="img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                                                <?php else: ?>
                                                                    <div class="avatar-text bg-soft-primary text-primary rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 16px;">
                                                                        <?= strtoupper(substr($wallet['nama_lengkap'] ?? 'T', 0, 1)) ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div>
                                                                <a href="<?= base_url('usermanagement/view/' . ($wallet['tukang_id'] ?? '')) ?>" class="fw-semibold text-dark d-block mb-1">
                                                                    <?= esc($wallet['nama_lengkap'] ?? '-') ?>
                                                                </a>
                                                                <div class="fs-11 text-muted">
                                                                    <i class="feather-phone me-1" style="width: 12px; height: 12px;"></i>
                                                                    <?= esc($wallet['no_telp'] ?? 'Tidak ada nomor') ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $alamat = $wallet['alamat'] ?? '';
                                                        $kota = $wallet['kota'] ?? '';
                                                        $provinsi = $wallet['provinsi'] ?? '';
                                                        ?>
                                                        
                                                        <?php if (!empty($alamat)): ?>
                                                            <div class="fs-13 mb-1">
                                                                <i class="feather-map-pin text-primary me-1" style="width: 13px; height: 13px;"></i>
                                                                <span class="fw-medium"><?= esc($alamat) ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if (!empty($kota) || !empty($provinsi)): ?>
                                                            <div class="fs-11 text-muted" style="padding-left: 18px;">
                                                                <?php 
                                                                $lokasi = array_filter([$kota, $provinsi]);
                                                                echo esc(implode(', ', $lokasi));
                                                                ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if (empty($alamat) && empty($kota) && empty($provinsi)): ?>
                                                            <div class="fs-12 text-muted">
                                                                <i class="feather-map-pin me-1" style="width: 12px; height: 12px;"></i>
                                                                <span>Alamat belum diisi</span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                                            <i class="feather-star text-warning" style="width: 16px; height: 16px;"></i>
                                                            <span class="fw-semibold"><?= esc(!empty($wallet['rating']) ? number_format($wallet['rating'], 1) : '0.0') ?></span>
                                                            <span class="text-muted fs-11">(<?= esc($wallet['jumlah_review'] ?? '0') ?>)</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-soft-warning text-warning px-3 py-2">
                                                            <i class="feather-zap me-1" style="width: 14px; height: 14px;"></i>
                                                            <?= esc(number_format($wallet['poin'] ?? 0, 0, ',', '.')) ?> Poin
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if (!empty($wallet['is_active']) && !empty($wallet['is_verified'])): ?>
                                                            <span class="badge bg-soft-success text-success px-3 py-2">
                                                                <i class="feather-check-circle me-1" style="width: 14px; height: 14px;"></i>Aktif
                                                            </span>
                                                        <?php elseif (!empty($wallet['is_verified'])): ?>
                                                            <span class="badge bg-soft-warning text-warning px-3 py-2">
                                                                <i class="feather-pause-circle me-1" style="width: 14px; height: 14px;"></i>Tidak Aktif
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="badge bg-soft-danger text-danger px-3 py-2">
                                                                <i class="feather-alert-circle me-1" style="width: 14px; height: 14px;"></i>Belum Verifikasi
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="hstack gap-2 justify-content-center">
                                                            <a href="<?= base_url('wallet-transaksi/detail/' . ($wallet['tukang_id'] ?? '')) ?>" 
                                                               class="avatar-text avatar-sm bg-soft-primary text-primary" 
                                                               data-bs-toggle="tooltip" 
                                                               title="Lihat Wallet">
                                                                <i class="feather-dollar-sign"></i>
                                                            </a>
                                                            <a href="<?= base_url('wallet-transaksi/history/' . ($wallet['tukang_id'] ?? '')) ?>" 
                                                               class="avatar-text avatar-sm bg-soft-info text-info" 
                                                               data-bs-toggle="tooltip" 
                                                               title="Riwayat Transaksi">
                                                                <i class="feather-clock"></i>
                                                            </a>
                                                            <a href="<?= base_url('usermanagement/view/' . ($wallet['tukang_id'] ?? '')) ?>" 
                                                               class="avatar-text avatar-sm bg-soft-secondary text-secondary" 
                                                               data-bs-toggle="tooltip" 
                                                               title="Lihat Profil">
                                                                <i class="feather-user"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7" class="text-center py-5">
                                                        <div class="text-muted">
                                                            <i class="feather-inbox fs-1 mb-3"></i>
                                                            <p class="mb-0">Tidak ada data wallet tukang.</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        Menampilkan <?= isset($wallets) ? count($wallets) : 0 ?> data
                                    </div>
                                        </ul>
                                    </nav>
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

        // Search functionality
        document.getElementById('searchWallet').addEventListener('keyup', function() {
            var searchValue = this.value.toLowerCase();
            var tableRows = document.querySelectorAll('#walletList tbody tr');
            
            tableRows.forEach(function(row) {
                var name = row.querySelector('td:nth-child(2)');
                if (name) {
                    var textValue = name.textContent || name.innerText;
                    if (textValue.toLowerCase().indexOf(searchValue) > -1) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });

        // Export data function
        function exportData() {
            // Simple CSV export
            var table = document.getElementById('walletList');
            var rows = table.querySelectorAll('tr');
            var csv = [];
            
            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll('td, th');
                for (var j = 0; j < cols.length - 1; j++) { // Exclude last column (actions)
                    var text = cols[j].innerText.replace(/,/g, ';');
                    row.push(text);
                }
                csv.push(row.join(','));
            }
            
            // Download CSV
            var csvContent = csv.join('\n');
            var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            var link = document.createElement('a');
            var url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', 'wallet_tukang_' + new Date().getTime() + '.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Add smooth scroll to top button
        window.onscroll = function() {
            var scrollBtn = document.getElementById('scrollTopBtn');
            if (scrollBtn) {
                if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                    scrollBtn.style.display = 'block';
                } else {
                    scrollBtn.style.display = 'none';
                }
            }
        };
    </script>