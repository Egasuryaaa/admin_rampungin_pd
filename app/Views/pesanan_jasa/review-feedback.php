<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="theme_ocean" />
    
    <title>Review & Feedback - Admin Tukang</title>
    <?php if (!function_exists('base_url')) { helper('url'); } ?>
    <base href="<?= base_url() ?>">
    
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/daterangepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .rating-stars {
            color: #ffc107;
        }
        .rating-stars i {
            font-size: 1.1rem;
        }
        .review-card {
            transition: all 0.3s ease;
        }
        .review-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .review-text {
            line-height: 1.6;
            color: #6c757d;
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
                        <h5 class="m-b-10">Review & Feedback</h5>
                    </div>
                <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Pesanan Jasa</a></li>
                        <li class="breadcrumb-item">Review & Feedback</li>
                </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-icon btn-light-brand" data-bs-toggle="tooltip" title="Export Data">
                            <i class="feather-download"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="main-content">
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div class="d-flex gap-4 align-items-center">
                                        <div class="avatar-text avatar-lg bg-soft-primary text-primary">
                                            <i class="feather-star"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold text-dark">
                                                <?php 
                                                $totalReviews = isset($ratings) ? count($ratings) : 0;
                                                echo $totalReviews;
                                                ?>
                                            </div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Review</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div class="d-flex gap-4 align-items-center">
                                        <div class="avatar-text avatar-lg bg-soft-warning text-warning">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold text-dark">
                                                <?php 
                                                if (isset($ratings) && !empty($ratings)) {
                                                    $avgRating = array_sum(array_column($ratings, 'rating')) / count($ratings);
                                                    echo number_format($avgRating, 1);
                                                } else {
                                                    echo '0.0';
                                                }
                                                ?>
                                            </div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Rating Rata-rata</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div class="d-flex gap-4 align-items-center">
                                        <div class="avatar-text avatar-lg bg-soft-success text-success">
                                            <i class="feather-thumbs-up"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold text-dark">
                                                <?php 
                                                if (isset($ratings) && !empty($ratings)) {
                                                    $fiveStars = count(array_filter($ratings, function($r) { return $r['rating'] == 5; }));
                                                    echo $fiveStars;
                                                } else {
                                                    echo '0';
                                                }
                                                ?>
                                            </div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Rating 5 Bintang</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div class="d-flex gap-4 align-items-center">
                                        <div class="avatar-text avatar-lg bg-soft-info text-info">
                                            <i class="feather-message-square"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold text-dark">
                                                <?php 
                                                if (isset($ratings) && !empty($ratings)) {
                                                    $withReview = count(array_filter($ratings, function($r) { return !empty($r['ulasan']); }));
                                                    echo $withReview;
                                                } else {
                                                    echo '0';
                                                }
                                                ?>
                                            </div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Dengan Ulasan</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review List -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Semua Review & Feedback</h5>
                                <div class="card-header-action">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari review..." id="searchReview">
                                        <button class="btn btn-light-brand" type="button">
                                            <i class="feather-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <?php if (isset($ratings) && !empty($ratings)): ?>
                                    <div class="p-4">
                                        <?php foreach ($ratings as $rating): ?>
                                        <div class="review-card border rounded p-4 mb-3">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="d-flex gap-3">
                                                    <img src="<?= base_url($rating['client_foto'] ?? 'assets/images/avatar/default.png') ?>" 
                                                         alt="client" 
                                                         class="rounded-circle"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-1">
                                                            <a href="<?= base_url('usermanagement/view/' . ($rating['client_id'] ?? '')) ?>" 
                                                               class="text-dark fw-semibold">
                                                                <?= esc($rating['nama_client'] ?? 'User Dihapus') ?>
                                                            </a>
                                                        </h6>
                                                        <div class="rating-stars mb-1">
                                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                <i class="fas fa-star<?= $i <= ($rating['rating'] ?? 0) ? '' : '-o' ?>"></i>
                                                            <?php endfor; ?>
                                                        </div>
                                                        <small class="text-muted">
                                                            <i class="feather-clock me-1"></i>
                                                            <?= esc(isset($rating['created_at']) ? date('d M Y, H:i', strtotime($rating['created_at'])) : '-') ?>
                                                        </small>
                                                    </div>
                                                </div>
                                                <span class="badge bg-soft-primary text-primary">
                                                    <?= esc($rating['rating'] ?? 0) ?>/5
                                                </span>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <div class="text-muted mb-2">
                                                    <small>
                                                        <strong>Untuk Tukang:</strong>
                                                        <a href="<?= base_url('usermanagement/view/' . ($rating['tukang_id'] ?? '')) ?>">
                                                            <?= esc($rating['nama_tukang'] ?? 'User Dihapus') ?>
                                                        </a>
                                                    </small>
                                                </div>
                                                <div class="text-muted">
                                                    <small>
                                                        <strong>Transaksi:</strong>
                                                        <a href="<?= base_url('wallet-transaksi/transaksi-view/' . ($rating['transaksi_id'] ?? '')) ?>">
                                                            <?= esc($rating['nomor_pesanan'] ?? '-') ?>
                                                        </a>
                                                        - <?= esc($rating['judul_layanan'] ?? '-') ?>
                                                    </small>
                                                </div>
                                            </div>
                                            
                                            <?php if (!empty($rating['ulasan'])): ?>
                                            <div class="review-text">
                                                <p class="mb-0"><?= esc($rating['ulasan']) ?></p>
                                            </div>
                                            <?php else: ?>
                                            <div class="text-muted fst-italic">
                                                <small>Tidak ada ulasan tertulis</small>
                                            </div>
                                            <?php endif; ?>
                                            
                                            <div class="d-flex gap-2 mt-3 pt-3 border-top">
                                                <a href="<?= base_url('wallet-transaksi/transaksi-view/' . ($rating['transaksi_id'] ?? '')) ?>" 
                                                   class="btn btn-sm btn-light-brand">
                                                    <i class="feather-eye me-1"></i>
                                                    Lihat Transaksi
                                                </a>
                                                <a href="<?= base_url('usermanagement/view/' . ($rating['tukang_id'] ?? '')) ?>" 
                                                   class="btn btn-sm btn-light">
                                                    <i class="feather-user me-1"></i>
                                                    Profil Tukang
                                                </a>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="feather-message-circle fs-1 mb-3"></i>
                                            <p class="mb-0">Belum ada review dan feedback.</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
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
        document.getElementById('searchReview').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const reviews = document.querySelectorAll('.review-card');
            
            reviews.forEach(function(review) {
                const text = review.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    review.style.display = '';
                } else {
                    review.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>