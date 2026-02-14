  <!-- Main Sidebar -->
  <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
      <a href="<?= base_url('dashboard') ?>" class="brand-link">
        <img src="<?= base_url('adminlte/dist/assets/img/AdminLTELogo.png') ?>" alt="SARAH Logo" class="brand-image opacity-75 shadow">
        <span class="brand-text fw-light">SARAH</span>
      </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
          
          <!-- User Info (Custom Item) -->
          <li class="nav-item">
            <a href="<?= base_url('profile') ?>" class="nav-link <?= strpos(uri_string(), 'profile') === 0 ? 'active' : '' ?>">
              <img src="<?= base_url('adminlte/dist/assets/img/avatar.png') ?>" class="nav-icon rounded-circle" style="width: 25px; height: 25px;">
              <p>
                <?= session()->get('name') ?>
                <br>
                <small><?= ucfirst(session()->get('role')) ?></small>
              </p>
            </a>
          </li>
          <li class="nav-header">MENU</li>

          <li class="nav-item">
            <a href="<?= base_url('dashboard') ?>" class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-speedometer"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <?php if(session()->get('role') == 'siswa'): ?>
          <li class="nav-item">
            <a href="<?= base_url('activity') ?>" class="nav-link <?= uri_string() == 'activity' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-list-check"></i>
              <p>Riwayat Kegiatan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('activity/create') ?>" class="nav-link <?= uri_string() == 'activity/create' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-pencil-square"></i>
              <p>Input Kegiatan</p>
            </a>
          </li>
          <?php endif; ?>

          <?php if(session()->get('role') == 'guru' || session()->get('role') == 'admin'): ?>
          <li class="nav-item">
            <a href="<?= base_url('validation') ?>" class="nav-link <?= uri_string() == 'validation' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-check2-square"></i>
              <p>Validasi Ibadah</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('grades') ?>" class="nav-link <?= uri_string() == 'grades' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-clipboard-data"></i>
              <p>Daftar Nilai</p>
            </a>
          </li>
          <?php endif; ?>

          <?php if(session()->get('role') == 'walas' || session()->get('role') == 'admin'): ?>
          <li class="nav-item">
            <a href="<?= base_url('monitoring') ?>" class="nav-link <?= uri_string() == 'monitoring' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-graph-up"></i>
              <p>Monitoring Kelas</p>
            </a>
          </li>
          <?php endif; ?>

          <?php if(session()->get('role') == 'admin'): ?>
          <li class="nav-header">ADMINISTRATOR</li>
          <li class="nav-item">
            <a href="<?= base_url('users') ?>" class="nav-link <?= strpos(uri_string(), 'users') === 0 ? 'active' : '' ?>">
              <i class="nav-icon bi bi-people-fill"></i>
              <p>Manajemen User</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('classes') ?>" class="nav-link <?= strpos(uri_string(), 'classes') === 0 ? 'active' : '' ?>">
              <i class="nav-icon bi bi-building"></i>
              <p>Manajemen Kelas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('institution') ?>" class="nav-link <?= strpos(uri_string(), 'institution') === 0 ? 'active' : '' ?>">
              <i class="nav-icon bi bi-bank"></i>
              <p>Data Instansi</p>
            </a>
          </li>
          <?php endif; ?>

        </ul>
      </nav>
    </div>
  </aside>
