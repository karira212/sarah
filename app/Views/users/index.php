<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h3 class="mb-0">Manajemen User</h3>
        </div>
        <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
          <a href="<?= base_url('users/import') ?>" class="btn btn-success me-2">
            <i class="bi bi-file-earmark-spreadsheet"></i> Import CSV
          </a>
          <a href="<?= base_url('users/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah User
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      
      <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= session()->getFlashdata('msg') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <div class="card shadow-sm">
        <div class="card-header">
          <form action="" method="get">
            <div class="row g-2">
              <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama/Username..." value="<?= esc($search) ?>">
              </div>
              <div class="col-md-2">
                <select name="role" class="form-select">
                  <option value="">Semua Role</option>
                  <option value="admin" <?= $role == 'admin' ? 'selected' : '' ?>>Admin</option>
                  <option value="guru" <?= $role == 'guru' ? 'selected' : '' ?>>Guru</option>
                  <option value="walas" <?= $role == 'walas' ? 'selected' : '' ?>>Wali Kelas</option>
                  <option value="siswa" <?= $role == 'siswa' ? 'selected' : '' ?>>Siswa</option>
                </select>
              </div>
              <div class="col-md-2">
                <select name="perPage" class="form-select">
                  <option value="10" <?= ($perPage ?? 10) == 10 ? 'selected' : '' ?>>10</option>
                  <option value="25" <?= ($perPage ?? 10) == 25 ? 'selected' : '' ?>>25</option>
                  <option value="50" <?= ($perPage ?? 10) == 50 ? 'selected' : '' ?>>50</option>
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                  <i class="bi bi-search"></i> Filter
                </button>
              </div>
            </div>
          </form>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Username</th>
                  <th>Role</th>
                  <th>Kelas</th>
                  <th>Status</th>
                  <th class="text-center" style="width: 200px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php if(empty($users)): ?>
                  <tr><td colspan="7" class="text-center py-4">Data tidak ditemukan</td></tr>
                <?php else: ?>
                  <?php foreach($users as $index => $user): ?>
                  <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= esc($user['name']) ?></td>
                    <td><?= esc($user['username']) ?></td>
                    <td>
                      <span class="badge text-bg-<?= $user['role'] == 'admin' ? 'danger' : ($user['role'] == 'guru' ? 'info' : ($user['role'] == 'walas' ? 'warning' : 'secondary')) ?>">
                        <?= ucfirst($user['role']) ?>
                      </span>
                    </td>
                    <td><?= $user['class_name'] ?: '-' ?></td>
                    <td>
                      <?php
                        $lastSeen = isset($user['updated_at']) ? strtotime($user['updated_at']) : 0;
                        $isOnline = $lastSeen && (time() - $lastSeen) < 300;
                      ?>
                      <span class="badge text-bg-<?= $isOnline ? 'success' : 'secondary' ?>">
                        <?= $isOnline ? 'Online' : 'Offline' ?>
                      </span>
                    </td>
                    <td class="text-center">
                      <div class="btn-group btn-group-sm">
                        <a href="<?= base_url('users/edit/'.$user['id']) ?>" class="btn btn-warning" title="Edit">
                          <i class="bi bi-pencil"></i>
                        </a>
                        <a href="<?= base_url('users/reset-password/'.$user['id']) ?>" class="btn btn-secondary" title="Reset Password (123456)" onclick="return confirm('Reset password user ini menjadi 123456?')">
                          <i class="bi bi-key"></i>
                        </a>
                        <a href="<?= base_url('users/delete/'.$user['id']) ?>" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus user ini?')">
                          <i class="bi bi-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer clearfix">
          <?= $pager->links('users', 'modern') ?>
        </div>
      </div>

    </div>
  </div>
</main>

<?= $this->include('layouts/footer') ?>
