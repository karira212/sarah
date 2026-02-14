<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/sidebar') ?>

  <!-- App Main -->
  <main class="app-main">
    <!-- Content Header -->
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3 class="mb-0"><?= $title ?></h3>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="app-content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
           <div class="col-12">
               <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
               <?php endif; ?>
               
               <div class="card card-primary card-outline mb-4">
                   <div class="card-header">
                       <h3 class="card-title">Welcome, <?= session()->get('name') ?>!</h3>
                   </div>
                   <div class="card-body">
                       You are logged in as <strong><?= ucfirst(session()->get('role')) ?></strong>.
                       <br>
                       <?php if(session()->get('role') == 'siswa'): ?>
                        <a href="<?= base_url('activity/create') ?>" class="btn btn-primary mt-3">Isi Kegiatan Hari Ini</a>
                       <?php endif; ?>
                   </div>
               </div>
           </div>
        </div>
      </div>
    </div>
    <!-- /.content -->
  </main>
  <!-- /.app-main -->

<?= view('layouts/footer') ?>
