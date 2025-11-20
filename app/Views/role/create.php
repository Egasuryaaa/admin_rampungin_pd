<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Role - Admin Tukang</title>
    <?php if (! function_exists('base_url')) { helper('url'); } ?>
    <base href="<?= base_url() ?>">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <!-- Main Content -->
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Tambah Role Baru</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="/role">Manajemen Role</a></li>
                        <li class="breadcrumb-item active">Tambah Role</li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <!-- Validation Errors -->
                                <?php if (session()->getFlashdata('errors')): ?>
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                                <li><?= $error ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <form action="<?= base_url('role/store') ?>" method="POST">
                                    <?= csrf_field() ?>
                                    
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Role <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?= old('name') ?>" required
                                               placeholder="Masukkan nama role">
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" id="description" name="description" 
                                                  rows="3" placeholder="Masukkan deskripsi role"><?= old('description') ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Permissions</label>
                                        <div class="row">
                                            <?php foreach ($permissions ?? [] as $permission): ?>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="permissions[]" 
                                                           value="<?= $permission['id'] ?>"
                                                           id="perm_<?= $permission['id'] ?>">
                                                    <label class="form-check-label" for="perm_<?= $permission['id'] ?>">
                                                        <?= $permission['name'] ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="<?= base_url('role') ?>" class="btn btn-secondary">
                                            <i class="feather-arrow-left me-2"></i>Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="feather-save me-2"></i>Simpan Role
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="assets/vendors/js/vendors.min.js"></script>
    <script src="assets/js/common-init.min.js"></script>
</body>
</html>