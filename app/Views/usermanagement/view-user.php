<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="theme_ocean" />
    <title>Detail User - Admin Tukang</title>
    <?php if (! function_exists('base_url')) { helper('url'); } ?>
    <base href="<?= base_url() ?>">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/daterangepicker.min.css" />
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
                                        <h6 class="text-dark mb-0"><?= session()->get('ses_userName') ?? 'Admin' ?> <span class="badge bg-soft-success text-success ms-1">PRO</span></h6>
                                        <span class="fs-12 fw-medium text-muted"><?= session()->get('ses_userEmail') ?? 'email@example.com' ?></span>
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
                        <h5 class="m-b-10">Detail User</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('usermanagement/daftar-user') ?>">Daftar User</a></li>
                        <li class="breadcrumb-item">Detail User</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            <a href="<?= base_url('usermanagement/daftar-user') ?>" class="btn btn-light">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Kembali</span>
                            </a>
                            <a href="<?= base_url('usermanagement/edit/' . ($user['id'] ?? '')) ?>" class="btn btn-primary">
                                <i class="feather-edit me-2"></i>
                                <span>Edit User</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="avatar-text avatar-xl bg-soft-primary text-primary mx-auto mb-3" style="width: 100px; height: 100px; font-size: 48px; line-height: 100px;">
                                        <?= strtoupper(substr($user['username'] ?? 'U', 0, 1)) ?>
                                    </div>
                                    <h5 class="mb-1"><?= esc($user['username'] ?? 'N/A') ?></h5>
                                    <p class="text-muted mb-3"><?= esc($user['email'] ?? 'N/A') ?></p>
                                    
                                    <?php 
                                        // Definisikan status aktif sekali untuk konsistensi, sama seperti di daftar-user.php
                                        $isActive = ($user['is_active'] ?? false) === 't' || ($user['is_active'] ?? false) === true;
                                    ?>

                                    <div class="d-flex justify-content-center gap-2 mb-4">
                                        <?php if ($isActive): ?>
                                            <span class="badge bg-soft-success text-success">
                                                <i class="feather-check me-1"></i>Aktif
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-soft-danger text-danger">
                                                <i class="feather-x me-1"></i>Tidak Aktif 
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php 
                                            // Definisikan role di satu tempat untuk konsistensi
                                            $roleId = $user['id_role'] ?? 0;
                                            $roleName = $user['role_name'] ?? 'Unknown'; // Ambil dari controller
                                            $roleBadge = 'bg-soft-secondary text-secondary'; // Default

                                            switch ($roleId) {
                                                case 1: // Admin
                                                    $roleBadge = 'bg-soft-danger text-danger';
                                                    break;
                                                case 2: // Client
                                                    $roleBadge = 'bg-soft-info text-info';
                                                    break;
                                                case 3: // Tukang
                                                    $roleBadge = 'bg-soft-warning text-warning';
                                                    break;
                                            }
                                        ?>
                                        <span class="badge <?= $roleBadge ?>"><?= $roleName ?></span>
                                    </div>

                                    <div class="d-flex justify-content-around border-top pt-4">
                                        <div class="text-center">
                                            <h4 class="mb-0 text-warning">
                                                <i class="feather-star me-1"></i><?= esc($user['poin'] ?? 0) ?>
                                            </h4>
                                            <small class="text-muted">Poin</small>
                                        </div>
                                        <div class="vr"></div>
                                        <div class="text-center">
                                            <h4 class="mb-0"><?= $roleName ?></h4>
                                            <small class="text-muted">Status</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Informasi User</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="avatar-text avatar-md bg-soft-primary text-primary me-3">
                                                <i class="feather-hash"></i>
                                            </div>
                                            <div>
                                                <label class="text-muted mb-1 small">User ID</label>
                                                <h6 class="mb-0"><?= esc($user['id'] ?? 'N/A') ?></h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="avatar-text avatar-md bg-soft-primary text-primary me-3">
                                                <i class="feather-user"></i>
                                            </div>
                                            <div>
                                                <label class="text-muted mb-1 small">Username</label>
                                                <h6 class="mb-0"><?= esc($user['username'] ?? 'N/A') ?></h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="avatar-text avatar-md bg-soft-primary text-primary me-3">
                                                <i class="feather-mail"></i>
                                            </div>
                                            <div>
                                                <label class="text-muted mb-1 small">Email</label>
                                                <h6 class="mb-0"><?= esc($user['email'] ?? 'N/A') ?></h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="avatar-text avatar-md bg-soft-primary text-primary me-3">
                                                <i class="feather-phone"></i>
                                            </div>
                                            <div>
                                                <label class="text-muted mb-1 small">Phone</label>
                                                <h6 class="mb-0">
                                                    <?php if (!empty($user['no_telp'])): ?>
                                                        <?= esc($user['no_telp']) ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">Belum diisi</span>
                                                    <?php endif; ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="avatar-text avatar-md bg-soft-warning text-warning me-3">
                                                <i class="feather-star"></i>
                                            </div>
                                            <div>
                                                <label class="text-muted mb-1 small">Total Poin</label>
                                                <h6 class="mb-0"><?= esc($user['poin'] ?? 0) ?> Poin</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="avatar-text avatar-md bg-soft-info text-info me-3">
                                                <i class="feather-shield"></i>
                                            </div>
                                            <div>
                                                <label class="text-muted mb-1 small">Role</label>
                                                <h6 class="mb-0"><?= $roleName ?></h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="avatar-text avatar-md bg-soft-success text-success me-3">
                                                <i class="feather-check-circle"></i>
                                            </div>
                                            <div>
                                                <label class="text-muted mb-1 small">Status Akun</label>
                                                <h6 class="mb-0">
                                                    <?php if ($isActive): ?>
                                                        <span class="text-success">Aktif</span>
                                                    <?php else: ?>
                                                        <span class="text-danger">Tidak Aktif</span>
                                                    <?php endif; ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex align-items-start">
                                            <div class="avatar-text avatar-md bg-soft-secondary text-secondary me-3">
                                                <i class="feather-calendar"></i>
                                            </div>
                                            <div>
                                                <label class="text-muted mb-1 small">Tanggal Bergabung</label>
                                                <h6 class="mb-0">
                                                    <?php if (!empty($user['created_at'])): ?>
                                                        <?= date('d F Y, H:i', strtotime($user['created_at'])) ?> WIB
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Aksi Cepat</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="<?= base_url('usermanagement/edit/' . ($user['id'] ?? '')) ?>" class="btn btn-primary">
                                        <i class="feather-edit me-2"></i>Edit User
                                    </a>
                                    
                                    <?php if ($isActive): ?>
                                        <a href="javascript:void(0);" 
                                           class="btn btn-warning"
                                           onclick="confirmAction(
                                               '<?= base_url('usermanagement/deactivate/' . ($user['id'] ?? '')) ?>', 
                                               'Konfirmasi Nonaktifkan', 
                                               'Apakah anda yakin ingin menonaktifkan user ini?', 
                                               'Ya, Nonaktifkan',
                                               'question'
                                           )">
                                            <i class="feather-user-x me-2"></i>Nonaktifkan
                                        </a>
                                    <?php else: ?>
                                        <a href="javascript:void(0);" 
                                           class="btn btn-success"
                                           onclick="confirmAction(
                                               '<?= base_url('usermanagement/activate/' . ($user['id'] ?? '')) ?>', 
                                               'Konfirmasi Aktifkan', 
                                               'Apakah anda yakin ingin mengaktifkan user ini?', 
                                               'Ya, Aktifkan',
                                               'question'
                                           )">
                                            <i class="feather-user-check me-2"></i>Aktifkan
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="javascript:void(0);" 
                                       class="btn btn-info"
                                       onclick="confirmAction(
                                           '<?= base_url('usermanagement/reset-password/' . ($user['id'] ?? '')) ?>',
                                           'Konfirmasi Reset Password',
                                           'Apakah anda yakin ingin mereset password user ini?',
                                           'Ya, Reset',
                                           'warning'
                                       )">
                                        <i class="feather-key me-2"></i>Reset Password
                                    </a>
                                    
                                    <a href="javascript:void(0);" 
                                       class="btn btn-danger"
                                       onclick="deleteUser(<?= $user['id'] ?? 0 ?>)">
                                        <i class="feather-trash-2 me-2"></i>Hapus User
                                    </a>
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
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        const BaseUrl = '<?= base_url() ?>';
        
        /**
         * Fungsi konfirmasi umum untuk aksi yang hanya me-redirect (bukan AJAX)
         * seperti Activate, Deactivate, Reset Password.
         */
        function confirmAction(url, title, text, confirmButtonText, icon = 'warning') {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Batal',
                confirmButtonColor: (icon === 'warning' || icon === 'error') ? '#d33' : '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, alihkan ke URL aksi
                    window.location.href = url;
                }
            });
        }

        /**
         * Fungsi Hapus User (menggunakan AJAX, sama seperti di daftar-user.php)
         * Endpoint 'usermanagement/delete/' diasumsikan mengembalikan JSON
         */
        function deleteUser(userId) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus user ini? Aksi ini tidak dapat dibatalkan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: BaseUrl + 'usermanagement/delete/' + userId,
                        type: 'POST', // Sesuai dengan standar di daftar-user
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                Swal.fire('Terhapus!', response.pesan, 'success').then(() => {
                                    // Karena user sudah dihapus, kembali ke halaman daftar
                                    window.location.href = BaseUrl + 'usermanagement/daftar-user';
                                });
                            } else {
                                Swal.fire('Gagal!', response.pesan, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Terjadi kesalahan sistem', 'error');
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>