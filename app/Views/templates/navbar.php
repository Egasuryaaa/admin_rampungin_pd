<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="<?= base_url('dashboard') ?>" class="b-brand">
                <img src="assets/images/logo-full.png" alt="" class="logo logo-lg" />
                <img src="assets/images/logo-abbr.png" alt="" class="logo logo-sm" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>
                
                <!-- Dashboard - Icon: Grid/Layout -->
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-grid"></i></span>
                        <span class="nxl-mtext">Dashboards</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('dashboard') ?>">Ringkasan total</a></li>
                    </ul>
                </li>
                
                <!-- User Management - Icon: Users -->
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-users"></i></span>
                        <span class="nxl-mtext">User Management</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('admin/users/clients') ?>">Daftar Client</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('admin/users/tukang') ?>">Daftar Tukang</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('admin/users/verifications/tukang') ?>">Verifikasi Tukang</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('admin/users') ?>">Semua User</a></li>
                    </ul>
                </li>
                
                <!-- Finance Management - Icon: Credit Card -->
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-credit-card"></i></span>
                        <span class="nxl-mtext">Keuangan</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('admin/finance/topup') ?>">Kelola Top-Up</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('admin/finance/withdrawal') ?>">Kelola Penarikan</a></li>
                    </ul>
                </li>
                

                
                <!-- Kategori & Transaksi - Icon: Layers -->
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-layers"></i></span>
                        <span class="nxl-mtext">Master Data</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('admin/categories') ?>">Kategori Tukang</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('admin/transactions') ?>">Monitor Transaksi</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>