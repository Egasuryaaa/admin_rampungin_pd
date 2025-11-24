<?php include APPPATH . 'Views/templates/header.php'; ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Monitoring Transaksi</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Transaksi</li>
                    </ul>
                </div>
            </div>

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

            <div class="main-content">
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="<?= base_url('admin/transactions') ?>">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="">Semua Status</option>
                                                <option value="pending" <?= (isset($_GET['status']) && $_GET['status'] === 'pending') ? 'selected' : '' ?>>Pending</option>
                                                <option value="diterima" <?= (isset($_GET['status']) && $_GET['status'] === 'diterima') ? 'selected' : '' ?>>Diterima</option>
                                                <option value="dalam_proses" <?= (isset($_GET['status']) && $_GET['status'] === 'dalam_proses') ? 'selected' : '' ?>>Dalam Proses</option>
                                                <option value="selesai" <?= (isset($_GET['status']) && $_GET['status'] === 'selesai') ? 'selected' : '' ?>>Selesai</option>
                                                <option value="ditolak" <?= (isset($_GET['status']) && $_GET['status'] === 'ditolak') ? 'selected' : '' ?>>Ditolak</option>
                                                <option value="dibatalkan" <?= (isset($_GET['status']) && $_GET['status'] === 'dibatalkan') ? 'selected' : '' ?>>Dibatalkan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Metode Pembayaran</label>
                                            <select name="metode_pembayaran" class="form-select">
                                                <option value="">Semua Metode</option>
                                                <option value="POIN" <?= (isset($_GET['metode_pembayaran']) && $_GET['metode_pembayaran'] === 'POIN') ? 'selected' : '' ?>>Poin</option>
                                                <option value="TUNAI" <?= (isset($_GET['metode_pembayaran']) && $_GET['metode_pembayaran'] === 'TUNAI') ? 'selected' : '' ?>>Tunai</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control" name="start_date" 
                                                   value="<?= $_GET['start_date'] ?? '' ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Tanggal Akhir</label>
                                            <input type="date" class="form-control" name="end_date" 
                                                   value="<?= $_GET['end_date'] ?? '' ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">&nbsp;</label>
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="feather-filter"></i> Filter
                                                </button>
                                                <a href="<?= base_url('admin/transactions') ?>" class="btn btn-secondary">
                                                    <i class="feather-refresh-cw"></i> Reset
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Daftar Transaksi</h5>
                                <div class="card-header-action">
                                    <a href="<?= base_url('admin/transactions/export?' . http_build_query($_GET)) ?>" 
                                       class="btn btn-sm btn-success">
                                        <i class="feather-download"></i> Export Excel
                                    </a>
                                </div>
                            </div>
                            <div class="card-body custom-card-action p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="transactionsTable">
                                        <thead>
                                            <tr>
                                                <th>No Pesanan</th>
                                                <th>Client</th>
                                                <th>Tukang</th>
                                                <th>Kategori</th>
                                                <th>Judul Layanan</th>
                                                <th>Lokasi</th>
                                                <th>Total Biaya</th>
                                                <th>Metode</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($transactions) && is_array($transactions)): ?>
                                                <?php foreach ($transactions as $trx): ?>
                                                    <tr>
                                                        <td><strong><?= esc($trx['nomor_pesanan'] ?? 'N/A') ?></strong></td>
                                                        <td>
                                                            <?php if (!empty($trx['users_transaksi_client_idTousers'])): ?>
                                                                <strong><?= esc($trx['users_transaksi_client_idTousers']['nama_lengkap'] ?? 'N/A') ?></strong><br>
                                                                <small class="text-muted"><?= esc($trx['users_transaksi_client_idTousers']['username'] ?? '') ?></small>
                                                            <?php else: ?>
                                                                <span class="text-muted">N/A</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($trx['users_transaksi_tukang_idTousers'])): ?>
                                                                <strong><?= esc($trx['users_transaksi_tukang_idTousers']['nama_lengkap'] ?? 'N/A') ?></strong><br>
                                                                <small class="text-muted"><?= esc($trx['users_transaksi_tukang_idTousers']['username'] ?? '') ?></small>
                                                            <?php else: ?>
                                                                <span class="text-muted">N/A</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($trx['kategori'])): ?>
                                                                <span class="badge bg-secondary">
                                                                    <?= esc($trx['kategori']['nama'] ?? 'N/A') ?>
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="text-muted">N/A</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= esc($trx['judul_layanan'] ?? '-') ?></td>
                                                        <td>
                                                            <small><?= esc($trx['lokasi_kerja'] ?? '-') ?></small>
                                                        </td>
                                                        <td><strong>Rp <?= number_format($trx['total_biaya'] ?? 0, 0, ',', '.') ?></strong></td>
                                                        <td>
                                                            <?php
                                                            $metode = strtoupper($trx['metode_pembayaran'] ?? 'N/A');
                                                            $metodeBadge = [
                                                                'POIN' => 'primary',
                                                                'TUNAI' => 'success'
                                                            ][$metode] ?? 'secondary';
                                                            ?>
                                                            <span class="badge bg-<?= $metodeBadge ?>">
                                                                <?= $metode ?>
                                                            </span>
                                                        </td>
                                                        <td><small><?= date('d M Y', strtotime($trx['created_at'] ?? 'now')) ?></small></td>
                                                        <td>
                                                            <a href="<?= base_url('admin/transactions/detail/' . ($trx['id'])) ?>" 
                                                               class="btn btn-sm btn-info" title="Detail Transaksi">
                                                                <i class="feather-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="10" class="text-center">Tidak ada data transaksi</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <?php if (!empty($pagination)): ?>
                                <div class="card-footer">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <p class="mb-0">
                                                Menampilkan <?= ($pagination['current_page'] - 1) * ($pagination['per_page'] ?? 10) + 1 ?> 
                                                - <?= min($pagination['current_page'] * ($pagination['per_page'] ?? 10), $pagination['total']) ?> 
                                                dari <?= $pagination['total'] ?> transaksi
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination justify-content-end mb-0">
                                                    <?php if ($pagination['current_page'] > 1): ?>
                                                        <li class="page-item">
                                                            <a class="page-link" href="?page=<?= $pagination['current_page'] - 1 ?><?= !empty($_GET['status']) ? '&status=' . $_GET['status'] : '' ?><?= !empty($_GET['metode_pembayaran']) ? '&metode_pembayaran=' . $_GET['metode_pembayaran'] : '' ?><?= !empty($_GET['start_date']) ? '&start_date=' . $_GET['start_date'] : '' ?><?= !empty($_GET['end_date']) ? '&end_date=' . $_GET['end_date'] : '' ?>">Previous</a>
                                                        </li>
                                                    <?php else: ?>
                                                        <li class="page-item disabled">
                                                            <span class="page-link" style="color: #6c757d; background-color: #fff; border-color: #dee2e6;">Previous</span>
                                                        </li>
                                                    <?php endif; ?>
                                                    
                                                    <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                                                        <li class="page-item <?= ($i == $pagination['current_page']) ? 'active' : '' ?>">
                                                            <a class="page-link" href="?page=<?= $i ?><?= !empty($_GET['status']) ? '&status=' . $_GET['status'] : '' ?><?= !empty($_GET['metode_pembayaran']) ? '&metode_pembayaran=' . $_GET['metode_pembayaran'] : '' ?><?= !empty($_GET['start_date']) ? '&start_date=' . $_GET['start_date'] : '' ?><?= !empty($_GET['end_date']) ? '&end_date=' . $_GET['end_date'] : '' ?>"><?= $i ?></a>
                                                        </li>
                                                    <?php endfor; ?>
                                                    
                                                    <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                                        <li class="page-item">
                                                            <a class="page-link" href="?page=<?= $pagination['current_page'] + 1 ?><?= !empty($_GET['status']) ? '&status=' . $_GET['status'] : '' ?><?= !empty($_GET['metode_pembayaran']) ? '&metode_pembayaran=' . $_GET['metode_pembayaran'] : '' ?><?= !empty($_GET['start_date']) ? '&start_date=' . $_GET['start_date'] : '' ?><?= !empty($_GET['end_date']) ? '&end_date=' . $_GET['end_date'] : '' ?>">Next</a>
                                                        </li>
                                                    <?php else: ?>
                                                        <li class="page-item disabled">
                                                            <span class="page-link" style="color: #6c757d; background-color: #fff; border-color: #dee2e6;">Next</span>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php include APPPATH . 'Views/templates/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#transactionsTable').DataTable({
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "order": [[8, "desc"]] // Sort by date column (index 8)
        });
    });
</script>
