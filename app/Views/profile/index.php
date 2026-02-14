<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/sidebar') ?>

<main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3 class="mb-0">Profil Saya</h3>
          </div>
        </div>
      </div>
    </div>

    <div class="app-content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Profil</h3>
                    </div>
                    <div class="card-body">
                        <?php if(session()->getFlashdata('success')):?>
                            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                        <?php endif;?>

                        <?php if(session()->getFlashdata('validation')):?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('validation')->listErrors() ?></div>
                        <?php endif;?>

                        <form action="<?= base_url('profile/update') ?>" method="post">
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $user['name']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user['username']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <input type="text" class="form-control" value="<?= ucfirst($user['role']) ?>" disabled>
                                <div class="form-text">Role tidak dapat diubah.</div>
                            </div>

                            <hr>
                            <p class="text-muted">Isi password jika ingin mengubahnya.</p>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>

                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="password_confirm" name="password_confirm">
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
