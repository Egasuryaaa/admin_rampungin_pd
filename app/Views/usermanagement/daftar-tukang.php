<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="theme_ocean" />
    <title>Daftar Tukang - Admin Tukang</title>
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
    <!-- Navigation Menu -->
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

    <!-- Header -->
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
                                        <h6 class="text-dark mb-0">Admin <span class="badge bg-soft-success text-success ms-1">PRO</span></h6>
                                        <span class="fs-12 fw-medium text-muted">admin@tukang.com</span>
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
                            <a href="./auth-login-minimal.html" class="dropdown-item">
                                <i class="feather-log-out"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Daftar Tukang</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                        <li class="breadcrumb-item">Daftar Tukang</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            <a href="<?= base_url('usermanagement/create-tukang') ?>" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Tambah Tukang</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tukangList">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Username</th>
                                                <th>Nama Lengkap</th>
                                                <th>Email</th>
                                                <th>No. Telepon</th>
                                                <th>Alamat</th>
                                                <th>Kota</th>
                                                <th>Poin/Saldo</th>
                                                <th>Status</th>
                                                <th>Verifikasi</th>
                                                <th class="text-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($tukang) && !empty($tukang)): ?>
                                                <?php foreach ($tukang as $user): ?>
                                                <tr>
                                                    <td><?= esc($user['id'] ?? '') ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="avatar-image avatar-md">
                                                                <?php if (!empty($user['foto_profil']) && file_exists($user['foto_profil'])): ?>
                                                                    <img src="<?= esc($user['foto_profil']) ?>" alt="" class="img-fluid" />
                                                                <?php else: ?>
                                                                    <img src="assets/images/avatar/default.png" alt="" class="img-fluid" /> 
                                                                <?php endif; ?>
                                                            </div>
                                                            <a href="<?= base_url('usermanagement/view-tukang/' . ($user['id'] ?? '')) ?>">
                                                                <span class="d-block"><?= esc($user['username'] ?? '') ?></span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fw-medium"><?= esc($user['nama_lengkap'] ?? '-') ?></span>
                                                    </td>
                                                    <td><?= esc($user['email'] ?? '') ?></td>
                                                    <td>
                                                        <?php if (!empty($user['no_telp']) && $user['no_telp'] !== '-'): ?>
                                                            <a href="tel:+62<?= esc($user['no_telp']) ?>" class="hstack gap-1">
                                                                <i class="feather-phone fs-12"></i>
                                                                <span><?= esc($user['no_telp']) ?></span>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($user['alamat'])): ?>
                                                            <span class="text-truncate d-inline-block" style="max-width: 200px;" data-bs-toggle="tooltip" title="<?= esc($user['alamat']) ?>">
                                                                <?= esc($user['alamat']) ?>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($user['kota'])): ?>
                                                            <span class="badge bg-soft-secondary text-secondary">
                                                                <i class="feather-map-pin me-1"></i><?= esc($user['kota']) ?>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">
                                                            <?= isset($user['poin']) ? 'Rp ' . number_format($user['poin'], 0, ',', '.') : 'Rp 0' ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if (isset($user['is_active']) && ($user['is_active'] === true || $user['is_active'] === 't' || $user['is_active'] == 1)): ?>
                                                            <span class="badge bg-success">
                                                                <i class="feather-check-circle me-1"></i>Aktif
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">
                                                                <i class="feather-x-circle me-1"></i>Tidak Aktif
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (isset($user['is_verified']) && ($user['is_verified'] === true || $user['is_verified'] === 't' || $user['is_verified'] == 1)): ?>
                                                            <span class="badge bg-info">
                                                                <i class="feather-shield me-1"></i>Verified
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning">
                                                                <i class="feather-alert-circle me-1"></i>Unverified
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <a href="<?= base_url('usermanagement/view-tukang/' . ($user['id'] ?? '')) ?>" 
                                                               class="avatar-text avatar-md" 
                                                               data-bs-toggle="tooltip" 
                                                               title="Lihat Detail">
                                                                <i class="feather-eye"></i>
                                                            </a>
                                                            <a href="<?= base_url('usermanagement/edit-tukang/' . ($user['id'] ?? '')) ?>" 
                                                               class="avatar-text avatar-md" 
                                                               data-bs-toggle="tooltip" 
                                                               title="Edit">
                                                                <i class="feather-edit"></i>
                                                            </a>
                                                            <a href="javascript:void(0);" 
                                                               class="avatar-text avatar-md delete-tukang" 
                                                               data-id="<?= esc($user['id'] ?? '') ?>"
                                                               data-username="<?= esc($user['username'] ?? '') ?>"
                                                               data-bs-toggle="tooltip" 
                                                               title="Hapus">
                                                                <i class="feather-trash-2"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="11" class="text-center py-5">
                                                        <div class="d-flex flex-column align-items-center">
                                                            <i class="feather-inbox fs-1 text-muted mb-3"></i>
                                                            <p class="text-muted mb-0">Tidak ada data tukang.</p>
                                                            <a href="<?= base_url('usermanagement/create-tukang') ?>" class="btn btn-sm btn-primary mt-3">
                                                                <i class="feather-plus me-1"></i>Tambah Tukang
                                                            </a>
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
        
        <!-- Footer -->
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

    <!-- Scripts -->
    <script src="assets/vendors/js/vendors.min.js"></script>
    <script src="assets/vendors/js/daterangepicker.min.js"></script>
    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/theme-customizer-init.min.js"></script>
    
    <script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Konfirmasi hapus tukang
        document.querySelectorAll('.delete-tukang').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const username = this.getAttribute('data-username');
                
                if (confirm(`Apakah Anda yakin ingin menghapus tukang "${username}"?\n\nData yang akan dihapus:\n- Profil tukang\n- Riwayat transaksi\n- Review dan rating\n\nTindakan ini tidak dapat dibatalkan!`)) {
                    // Redirect ke URL delete
                    window.location.href = '<?= base_url("usermanagement/delete-tukang/") ?>' + id;
                }
            });
        });
    });
    </script>
</body>

</html>