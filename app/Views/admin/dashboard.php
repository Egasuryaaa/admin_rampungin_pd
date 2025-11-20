<?php include APPPATH . 'Views/templates/header.php'; ?>


<!-- ega -->

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                </div>
            </div>
            
            <div class="main-content">
                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="feather-alert-circle"></i>
                        <?= esc($message ?? 'Gagal mengambil data dashboard') ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($stats) && !empty($stats)): ?>
                <!-- Statistics Cards -->
                <div class="row">
                    <!-- Total Users -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div class="d-flex gap-4 align-items-center">
                                        <div class="avatar-text avatar-lg bg-primary text-white">
                                            <i class="feather-users"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold text-dark">
                                                <span><?= esc($stats['users']['total'] ?? 0) ?></span>
                                            </div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Users</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fs-12 text-muted">Clients: <?= esc($stats['users']['client'] ?? 0) ?></span>
                                        <span class="fs-12 text-muted">Tukang: <?= esc($stats['users']['tukang'] ?? 0) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Topup -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div class="d-flex gap-4 align-items-center">
                                        <div class="avatar-text avatar-lg bg-warning text-white">
                                            <i class="feather-dollar-sign"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold text-dark">
                                                <span><?= esc($stats['finance']['pending_topup'] ?? 0) ?></span>
                                            </div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Pending Top-Up</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <a href="<?= base_url('admin/finance/topup') ?>" class="fs-12 fw-medium text-primary">
                                        Lihat Semua <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Withdrawal -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div class="d-flex gap-4 align-items-center">
                                        <div class="avatar-text avatar-lg bg-danger text-white">
                                            <i class="feather-trending-down"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold text-dark">
                                                <span><?= esc($stats['finance']['pending_withdrawal'] ?? 0) ?></span>
                                            </div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Pending Withdrawal</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <a href="<?= base_url('admin/finance/withdrawal') ?>" class="fs-12 fw-medium text-primary">
                                        Lihat Semua <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Unverified Tukang -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div class="d-flex gap-4 align-items-center">
                                        <div class="avatar-text avatar-lg bg-info text-white">
                                            <i class="feather-user-check"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold text-dark">
                                                <span><?= esc($stats['verifications']['unverified_tukang'] ?? 0) ?></span>
                                            </div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Unverified Tukang</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <a href="<?= base_url('admin/users/verifications/tukang') ?>" class="fs-12 fw-medium text-primary">
                                        Verifikasi <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transactions Summary -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Ringkasan Transaksi</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 text-center border-end">
                                        <div class="py-3">
                                            <h2 class="fw-bold text-primary"><?= esc($stats['transactions']['total'] ?? 0) ?></h2>
                                            <p class="text-muted mb-0">Total Transaksi</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center border-end">
                                        <div class="py-3">
                                            <h2 class="fw-bold text-warning"><?= esc($stats['transactions']['pending'] ?? 0) ?></h2>
                                            <p class="text-muted mb-0">Pending</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center border-end">
                                        <div class="py-3">
                                            <h2 class="fw-bold text-success"><?= esc($stats['transactions']['completed'] ?? 0) ?></h2>
                                            <p class="text-muted mb-0">Selesai</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <div class="py-3">
                                            <a href="<?= base_url('admin/transactions') ?>" class="btn btn-primary mt-3">
                                                Lihat Semua Transaksi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Welcome Card -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Selamat Datang, <?= esc(session()->get('nama_lengkap') ?? session()->get('username') ?? 'Admin') ?>!</h5>
                            </div>
                            <div class="card-body">
                                <p>Anda login sebagai <strong><?= esc(session()->get('role')) ?></strong></p>
                                <p class="mb-0">Gunakan menu navigasi di sebelah kiri untuk mengelola sistem admin Rampungin.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="feather-alert-triangle"></i>
                        Tidak ada data statistik yang dapat ditampilkan.
                    </div>
                <?php endif; ?>
            </div>
        </div>

<?php include APPPATH . 'Views/templates/footer.php'; ?>
