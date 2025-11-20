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
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('usermanagement/daftar-user') ?>">Daftar User</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('usermanagement/daftar-tukang')?>">Daftar Tukang</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('usermanagement/roles-and-permissions') ?>">Roles & Permissions</a></li>
                    </ul>
                </li>
                
                <!-- Wallet & Transaksi - Icon: Credit Card -->
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-credit-card"></i></span>
                        <span class="nxl-mtext">Wallet & Transaksi</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('wallet-transaksi/wallet-tukang') ?>">Wallet Tukang</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('wallet-transaksi/topup') ?>">Topup</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('wallet-transaksi/withdraw') ?>">Withdraw (tarik tunai)</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('wallet-transaksi/semua-transaksi') ?>">Transaksi</a></li>
                    </ul>
                </li>
                
                <!-- Rating & Feedback - Icon: Star -->
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-star"></i></span>
                        <span class="nxl-mtext">Rating & Feedback</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('orders/reviews') ?>">Review & Feedback</a></li>
                    </ul>
                </li>
                
                <!-- Kategori & Layanan - Icon: Layers atau Briefcase -->
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-layers"></i></span>
                        <span class="nxl-mtext">Kategori & Layanan</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="<?= base_url('categories') ?>">Kategori Tukang</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>