<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h3 class="mb-0">Import User CSV</h3>
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
      
      <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <div class="card shadow-sm">
        <div class="card-body">
          <div class="alert alert-info">
            <h5><i class="bi bi-info-circle"></i> Petunjuk Format CSV</h5>
            <p>Pastikan file CSV Anda memiliki urutan kolom sebagai berikut (tanpa header):</p>
            <ol>
              <li>Nama Lengkap</li>
              <li>Username (Unik)</li>
              <li>Password (Akan dienkripsi, default: 123456 jika kosong)</li>
              <li>Role (admin / guru / walas / siswa)</li>
              <li>ID Kelas (Angka, opsional)</li>
            </ol>
            <p class="mb-0">Contoh baris: <code>Ahmad Santoso,ahmad123,123456,siswa,1</code></p>
          </div>

          <form action="<?= base_url('users/process-import') ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label class="form-label">Upload File CSV</label>
              <input type="file" name="csv_file" class="form-control" accept=".csv" required>
            </div>

            <div class="mt-4">
              <button type="submit" class="btn btn-success">
                <i class="bi bi-upload"></i> Proses Import
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</main>

<?= $this->include('layouts/footer') ?>
