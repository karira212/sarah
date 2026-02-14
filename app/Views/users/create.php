<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h3 class="mb-0">Tambah User Baru</h3>
        </div>
        <div class="col-sm-6 text-end">
          <a href="<?= base_url('users') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      
      <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
          <ul>
          <?php foreach(session()->getFlashdata('errors') as $error): ?>
            <li><?= $error ?></li>
          <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <div class="card shadow-sm">
        <div class="card-body">
          <form action="<?= base_url('users/store') ?>" method="post">
            <div class="mb-3">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required>
            </div>
            
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" value="<?= old('username') ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                  <option value="">Pilih Role</option>
                  <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                  <option value="guru" <?= old('role') == 'guru' ? 'selected' : '' ?>>Guru Agama</option>
                  <option value="walas" <?= old('role') == 'walas' ? 'selected' : '' ?>>Wali Kelas</option>
                  <option value="siswa" <?= old('role') == 'siswa' ? 'selected' : '' ?>>Siswa</option>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Kelas (Opsional)</label>
                <select name="class_id" class="form-select">
                  <option value="">Pilih Kelas</option>
                  <?php foreach($classes as $class): ?>
                    <option value="<?= $class['id'] ?>" <?= old('class_id') == $class['id'] ? 'selected' : '' ?>>
                      <?= $class['name'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <small class="text-muted">Wajib diisi jika role adalah Siswa atau Wali Kelas</small>
              </div>
            </div>

            <div class="mt-4">
              <button type="submit" class="btn btn-primary">Simpan User</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</main>

<?= $this->include('layouts/footer') ?>
