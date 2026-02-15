<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h3 class="mb-0">Manajemen Kelas</h3>
        </div>
        <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
          <a href="<?= base_url('classes/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Kelas
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      
      <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success">
          <?= session()->getFlashdata('msg') ?>
        </div>
      <?php endif; ?>
      <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <div class="card shadow-sm">
        <div class="card-header">
          <form action="" method="get">
            <div class="row g-2">
              <div class="col-md-2 ms-auto">
                <select name="perPage" class="form-select">
                  <option value="10" <?= ($perPage ?? 10) == 10 ? 'selected' : '' ?>>10</option>
                  <option value="25" <?= ($perPage ?? 10) == 25 ? 'selected' : '' ?>>25</option>
                  <option value="50" <?= ($perPage ?? 10) == 50 ? 'selected' : '' ?>>50</option>
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                  <i class="bi bi-search"></i> Terapkan
                </button>
              </div>
            </div>
          </form>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
              <thead class="table-light">
                <tr>
                  <th width="5%">No</th>
                  <th>Nama Kelas</th>
                  <th>Wali Kelas</th>
                  <th width="15%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; foreach($classes as $class): ?>
                <tr>
                  <td><?= $i++ ?></td>
                  <td><?= $class['name'] ?></td>
                  <td>
                    <?php if($class['walas_name']): ?>
                      <span>
                        <i class="bi bi-person-badge me-1"></i><?= $class['walas_name'] ?>
                      </span>
                    <?php else: ?>
                      <span class="text-muted">Belum ada Wali Kelas</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm">
                      <a href="<?= base_url('classes/edit/'.$class['id']) ?>" class="btn btn-warning" title="Edit">
                        <i class="bi bi-pencil"></i>
                      </a>
                      <a href="<?= base_url('classes/delete/'.$class['id']) ?>" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus kelas ini?')">
                        <i class="bi bi-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($classes)): ?>
                <tr>
                  <td colspan="4" class="text-center text-muted">Belum ada data kelas</td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer clearfix">
          <?= $pager->links('classes', 'modern') ?>
        </div>
      </div>

    </div>
  </div>
</main>

<?= $this->include('layouts/footer') ?>
