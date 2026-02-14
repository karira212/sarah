<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h3 class="mb-0">Edit Kelas</h3>
        </div>
        <div class="col-sm-6 text-end">
          <a href="<?= base_url('classes') ?>" class="btn btn-secondary">
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
          <form action="<?= base_url('classes/update/'.$class['id']) ?>" method="post">
            <div class="mb-3">
              <label class="form-label">Nama Kelas</label>
              <input type="text" name="name" class="form-control" value="<?= old('name', $class['name']) ?>" required>
            </div>
            
            <div class="mb-3">
              <label class="form-label">Wali Kelas</label>
              <select name="wali_kelas_id" class="form-select" required>
                <option value="">Pilih Wali Kelas</option>
                <?php foreach($walas as $w): ?>
                  <option value="<?= $w['id'] ?>" <?= old('wali_kelas_id', $class['wali_kelas_id']) == $w['id'] ? 'selected' : '' ?>>
                    <?= $w['name'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mt-4">
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</main>

<?= $this->include('layouts/footer') ?>
