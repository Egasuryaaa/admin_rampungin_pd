<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="theme_ocean" />
    <title>Daftar User - Admin Tukang</title>
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
                        <h5 class="m-b-10">Daftar User</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                        <li class="breadcrumb-item">Daftar User</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            <a href="<?= base_url('usermanagement/create') ?>" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Tambah User</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content">
                <!-- Filter Card -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Filter User</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Role</label>
                                        <select id="filterRole" class="form-select">
                                            <option value="">Semua Role</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Client</option>
                                            <option value="3">Tukang</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Status</label>
                                        <select id="filterStatus" class="form-select">
                                            <option value="">Semua Status</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Non-Aktif</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Pencarian</label>
                                        <input type="text" id="filterSearch" class="form-control" placeholder="Cari username, email, nama...">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" id="btnFilter" class="btn btn-primary w-100">
                                            <i class="feather-search me-2"></i>Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Table -->
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="userTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Nama Lengkap</th>
                                                <th>Role</th>
                                                <th>Poin</th>
                                                <th>Status</th>
                                                <th>Verified</th>
                                                <th>Terdaftar</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($users) && !empty($users)): ?>
                                                <?php foreach ($users as $user): ?>
                                                <tr>
                                                    <td><?= esc($user['id'] ?? '') ?></td>
                                                    <td><?= esc($user['username'] ?? '') ?></td>
                                                    <td><?= esc($user['email'] ?? '') ?></td>
                                                    <td><?= esc($user['nama_lengkap'] ?? '-') ?></td>
                                                    <td>
                                                        <?php 
                                                        $roleBadges = [
                                                            'Admin' => 'bg-primary',
                                                            'Client' => 'bg-info',
                                                            'Tukang' => 'bg-warning'
                                                        ];
                                                        $roleName = $user['role_name'] ?? 'Unknown';
                                                        $badgeClass = $roleBadges[$roleName] ?? 'bg-secondary';
                                                        ?>
                                                        <span class="badge <?= $badgeClass ?>"><?= esc($roleName) ?></span>
                                                    </td>
                                                    <td><?= esc($user['poin'] ?? 0) ?></td>
                                                    <td>
                                                        <?php 
                                                        $isActive = ($user['is_active'] ?? false) === 't' || ($user['is_active'] ?? false) === true;
                                                        ?>
                                                        <span class="badge <?= $isActive ? 'bg-success' : 'bg-danger' ?>">
                                                            <?= $isActive ? 'Aktif' : 'Non-Aktif' ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php 
                                                        $isVerified = ($user['is_verified'] ?? false) === 't' || ($user['is_verified'] ?? false) === true;
                                                        ?>
                                                        <span class="badge <?= $isVerified ? 'bg-success' : 'bg-warning' ?>">
                                                            <i class="feather-<?= $isVerified ? 'check' : 'x' ?>-circle"></i>
                                                        </span>
                                                    </td>
                                                    <td><?= isset($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : '-' ?></td>
                                                    <td>
                                                        <div class="hstack gap-2 justify-content-center">
                                                            <a href="<?= base_url('usermanagement/view/' . ($user['id'] ?? '')) ?>" class="avatar-text avatar-sm" title="Lihat">
                                                                <i class="feather-eye"></i>
                                                            </a>
                                                            <a href="<?= base_url('usermanagement/edit/' . ($user['id'] ?? '')) ?>" class="avatar-text avatar-sm" title="Edit">
                                                                <i class="feather-edit"></i>
                                                            </a>
                                                            <a href="javascript:void(0);" onclick="toggleActive(<?= $user['id'] ?? 0 ?>)" class="avatar-text avatar-sm" title="Toggle Status">
                                                                <i class="feather-power"></i>
                                                            </a>
                                                            <a href="javascript:void(0);" onclick="deleteUser(<?= $user['id'] ?? 0 ?>)" class="avatar-text avatar-sm text-danger" title="Hapus">
                                                                <i class="feather-trash-2"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="10" class="text-center">Tidak ada data user.</td>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    const BaseUrl = '<?= base_url() ?>';
    
    $(document).ready(function() {
        // Only load via AJAX if users data is not provided from server
        <?php if (!isset($users) || empty($users)): ?>
        loadUsers();
        <?php endif; ?>
        
        // Filter button click
        $('#btnFilter').on('click', function() {
            loadUsers();
        });
    

        
        // Enter key on search
        $('#filterSearch').on('keypress', function(e) {
            if (e.which === 13) {
                loadUsers();
            }
        });
    });
    
    function loadUsers() {
        const role = $('#filterRole').val();
        const status = $('#filterStatus').val();
        const search = $('#filterSearch').val();
        
        $.ajax({
            url: BaseUrl + 'usermanagement/get-users',
            type: 'GET',
            data: {
                role_id: role,
                is_active: status,
                search: search
            },
            dataType: 'json',
            beforeSend: function() {
                $('#userTable tbody').html('<tr><td colspan="10" class="text-center"><i class="feather-loader spin"></i> Loading...</td></tr>');
            },
            success: function(response) {
                if (response.status && response.data.length > 0) {
                    let html = '';
                    response.data.forEach(function(user) {
                        const statusBadge = user.is_active === 't' || user.is_active === true ? 
                            '<span class="badge bg-success">Aktif</span>' : 
                            '<span class="badge bg-danger">Non-Aktif</span>';
                        
                        const verifiedBadge = user.is_verified === 't' || user.is_verified === true ? 
                            '<span class="badge bg-success"><i class="feather-check-circle"></i></span>' : 
                            '<span class="badge bg-warning"><i class="feather-x-circle"></i></span>';
                        
                        const roleBadge = getRoleBadge(user.role_name);
                        
                        html += '<tr>';
                        html += '<td>' + user.id + '</td>';
                        html += '<td>' + user.username + '</td>';
                        html += '<td>' + user.email + '</td>';
                        html += '<td>' + (user.nama_lengkap || '-') + '</td>';
                        html += '<td>' + roleBadge + '</td>';
                        html += '<td>' + (user.poin || 0) + '</td>';
                        html += '<td>' + statusBadge + '</td>';
                        html += '<td class="text-center">' + verifiedBadge + '</td>';
                        html += '<td>' + formatDate(user.created_at) + '</td>';
                        html += '<td>';
                        html += '<div class="hstack gap-2 justify-content-center">';
                        html += '<a href="' + BaseUrl + 'usermanagement/view/' + user.id + '" class="avatar-text avatar-sm" title="Lihat">';
                        html += '<i class="feather-eye"></i>';
                        html += '</a>';
                        html += '<a href="' + BaseUrl + 'usermanagement/edit/' + user.id + '" class="avatar-text avatar-sm" title="Edit">';
                        html += '<i class="feather-edit"></i>';
                        html += '</a>';
                        html += '<a href="javascript:void(0);" onclick="toggleActive(' + user.id + ')" class="avatar-text avatar-sm" title="Toggle Status">';
                        html += '<i class="feather-power"></i>';
                        html += '</a>';
                        html += '<a href="javascript:void(0);" onclick="deleteUser(' + user.id + ')" class="avatar-text avatar-sm text-danger" title="Hapus">';
                        html += '<i class="feather-trash-2"></i>';
                        html += '</a>';
                        html += '</div>';
                        html += '</td>';
                        html += '</tr>';
                    });
                    $('#userTable tbody').html(html);
                } else {
                    $('#userTable tbody').html('<tr><td colspan="10" class="text-center">Tidak ada data user.</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#userTable tbody').html('<tr><td colspan="10" class="text-center text-danger">Gagal memuat data. ' + error + '</td></tr>');
            }
        });
    }

        function getRoleBadge(roleName) {
            const badges = {
                'Admin': '<span class="badge bg-primary">Admin</span>',
                'Client': '<span class="badge bg-info">Client</span>',
                'Tukang': '<span class="badge bg-warning">Tukang</span>'
            };
            return badges[roleName] || '<span class="badge bg-secondary">' + roleName + '</span>';
        }
        
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
        }
        
        function toggleActive(userId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Ubah status aktif user ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ubah',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: BaseUrl + 'usermanagement/toggle-active/' + userId,
                        type: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                Swal.fire('Berhasil!', response.pesan, 'success');
                                loadUsers();
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
        
        function deleteUser(userId) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus user ini? Data tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: BaseUrl + 'usermanagement/delete/' + userId,
                        type: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                Swal.fire('Terhapus!', response.pesan, 'success');
                                loadUsers();
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