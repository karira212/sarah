<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/sidebar') ?>

<main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3 class="mb-0">Data Instansi</h3>
          </div>
        </div>
      </div>
    </div>

    <div class="app-content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Profil Sekolah</h3>
                    </div>
                    <div class="card-body">
                        <?php if(session()->getFlashdata('success')):?>
                            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                        <?php endif;?>

                        <?php if(session()->getFlashdata('validation')):?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('validation')->listErrors() ?></div>
                        <?php endif;?>

                        <form action="<?= base_url('institution/update') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $profile['id'] ?>">
                            
                            <div class="mb-3">
                                <label for="school_name" class="form-label">Nama Sekolah</label>
                                <input type="text" class="form-control" id="school_name" name="school_name" value="<?= $profile['school_name'] ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="school_address" class="form-label">Alamat Sekolah</label>
                                <textarea class="form-control" id="school_address" name="school_address" rows="3" required><?= $profile['school_address'] ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="headmaster_name" class="form-label">Nama Kepala Sekolah</label>
                                    <input type="text" class="form-control" id="headmaster_name" name="headmaster_name" value="<?= $profile['headmaster_name'] ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="headmaster_nip" class="form-label">NIP Kepala Sekolah</label>
                                    <input type="text" class="form-control" id="headmaster_nip" name="headmaster_nip" value="<?= $profile['headmaster_nip'] ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo Sekolah</label>
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <?php if($profile['logo']): ?>
                                            <img src="<?= base_url('uploads/'.$profile['logo']) ?>" alt="Logo Sekolah" class="img-thumbnail" style="height: 100px;">
                                        <?php else: ?>
                                            <img src="<?= base_url('adminlte/dist/assets/img/AdminLTELogo.png') ?>" alt="Default Logo" class="img-thumbnail" style="height: 100px;">
                                        <?php endif; ?>
                                    </div>
                                    <div class="col">
                                        <input type="file" class="form-control" id="logo" name="logo">
                                        <div class="form-text">Format: JPG/PNG, Max: 2MB. Biarkan kosong jika tidak ingin mengubah logo.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</main>

<?= view('layouts/footer') ?>
