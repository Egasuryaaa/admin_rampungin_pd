<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="theme_ocean" />

    <title>Dashboard - Admin Tukang</title>
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
                    
                    <div class="dropdown nxl-h-item">
                        <a class="nxl-head-link me-3" data-bs-toggle="dropdown" href="#" role="button" data-bs-auto-close="outside">
                            <i class="feather-bell"></i>
                            <span class="badge bg-danger nxl-h-badge d-none" id="notification-badge">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-notifications-dropdown" id="notification-dropdown" style="width: 360px;">
                            <div class="dropdown-header px-4 py-3">
                                <h6 class="mb-0 fw-bold">Notifikasi Topup Pending</h6>
                            </div>
                            <div class="dropdown-divider m-0"></div>
                            <div id="notification-list" style="max-height: 400px; overflow-y: auto;">
                                <!-- Notification items will be inserted here by JavaScript -->
                            </div>
                            <div class="dropdown-divider m-0"></div>
                            <div class="dropdown-footer text-center py-3">
                                <a href="wallet-transaksi/topup" class="fw-semibold" style="font-size: 13px; text-decoration: none;">
                                    Lihat Semua Topup <i class="feather-arrow-right ms-1" style="width: 14px; height: 14px;"></i>
                                </a>
                            </div>
                        </div>
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
                            <a href="<?= site_url('logout') ?>" class="dropdown-item">
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
                        <h5 class="m-b-10">Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                </div>
            </div>
            
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Selamat Datang, <?= esc($user['username'] ?? 'Admin') ?>!</h5>
                            </div>
                            <div class="card-body">
                                <p>Ini adalah halaman ringkasan dashboard Anda.</p>
                                <p>Semua aset (CSS/JS) sekarang seharusnya dimuat dengan benar karena kita menggunakan tag `<base>` di head.</p>
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
    $(document).ready(function() {
        function fetchNotifications() {
            $.ajax({
                url: '<?= base_url('notifications/pending-topups') ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('✅ Response:', response);
                    
                    if (response.status && response.data && response.data.length > 0) {
                        // Update badge - tampilkan dengan angka
                        $('#notification-badge')
                            .text(response.data.length)
                            .removeClass('d-none');

                        // Clear existing notifications
                        $('#notification-list').empty();

                        // Populate notification list
                        $.each(response.data, function(index, topup) {
                            // Badge expired
                            var expiredBadge = topup.is_expired ? 
                                '<span class="badge bg-danger" style="font-size: 9px; padding: 3px 6px; margin-left: 6px;">Expired</span>' : '';
                            
                            // Warna icon
                            var iconBgClass = topup.is_expired ? 'bg-secondary' : 'bg-primary';
                            
                            var notificationItem = `
                                <a href="<?= base_url('wallet-transaksi/topup-verifikasi/') ?>${topup.id}" 
                                   class="notification-item d-block text-decoration-none"
                                   style="padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); transition: all 0.2s;">
                                    <div class="d-flex align-items-center gap-3">
                                        <!-- Icon -->
                                        <div class="flex-shrink-0">
                                            <div class="${iconBgClass} text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 48px; height: 48px; font-size: 20px;">
                                                <i class="feather-dollar-sign"></i>
                                            </div>
                                        </div>
                                        
                                        <!-- Content -->
                                        <div class="flex-grow-1" style="min-width: 0;">
                                            <!-- Title + Badge -->
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="fw-bold text-truncate" style="font-size: 14px; max-width: 200px;">
                                                    Topup dari ${topup.username}
                                                </span>
                                                ${expiredBadge}
                                            </div>
                                            
                                            <!-- Amount -->
                                            <div class="fw-bold mb-2" style="color: #22c55e; font-size: 14px;">
                                                Rp ${new Intl.NumberFormat('id-ID').format(topup.jumlah)}
                                            </div>
                                            
                                            <!-- Time -->
                                            <div class="d-flex align-items-center text-muted" style="font-size: 12px;">
                                                <i class="feather-clock me-1" style="width: 13px; height: 13px;"></i>
                                                <span>${topup.created_at_human}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            `;
                            
                            $('#notification-list').append(notificationItem);
                        });
                        
                        // Hover effect untuk setiap item
                        $('.notification-item').on('mouseenter', function() {
                            $(this).css('background-color', 'rgba(255, 255, 255, 0.05)');
                        }).on('mouseleave', function() {
                            $(this).css('background-color', 'transparent');
                        });
                        
                    } else {
                        // Tidak ada notifikasi
                        $('#notification-badge').addClass('d-none');
                        $('#notification-list').html(`
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="feather-bell-off text-muted" style="font-size: 48px;"></i>
                                </div>
                                <p class="text-muted mb-0" style="font-size: 14px;">Tidak ada notifikasi baru</p>
                            </div>
                        `);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('❌ Error:', xhr.responseText);
                    
                    // Badge warning
                    $('#notification-badge')
                        .text('!')
                        .removeClass('d-none bg-danger')
                        .addClass('bg-warning');
                    
                    // Error message
                    $('#notification-list').html(`
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="feather-alert-circle text-danger" style="font-size: 48px;"></i>
                            </div>
                            <p class="text-danger mb-1" style="font-size: 14px;">Gagal memuat notifikasi</p>
                            <small class="text-muted" style="font-size: 12px;">${error}</small>
                        </div>
                    `);
                }
            });
        }

        // Fetch notifications on page load
        console.log('🔄 Fetching notifications...');
        fetchNotifications();

        // Auto refresh every 1 minute
        setInterval(function() {
            console.log('🔄 Auto-refresh notifications...');
            fetchNotifications();
        }, 60000);

        // Handle click notification item
        $(document).on('click', '.notification-item', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            window.location.href = url;
        });
    });
    </script>
</body>

</html>