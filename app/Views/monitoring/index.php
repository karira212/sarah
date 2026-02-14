<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/sidebar') ?>

<style>
@media print {
  .app-header, 
  .app-sidebar, 
  .app-footer, 
  .btn-tool, 
  .card-tools,
  .nav-link,
  .card-header,
  .breadcrumb { 
    display: none !important; 
  }
  
  .app-wrapper, .app-main { 
    margin: 0 !important; 
    padding: 0 !important;
    width: 100% !important;
    max-width: 100% !important;
    background-color: white !important;
  }
  
  .card {
    box-shadow: none !important;
    border: none !important;
  }
  
  body {
    background-color: white !important;
  }

  /* Hide URL after links */
  a[href]:after {
    content: none !important;
  }

  /* Ensure table fits */
  .table-responsive {
    overflow: visible !important;
  }
  
  /* Add a print header */
  .print-header {
    display: block !important;
    text-align: center;
    margin-bottom: 20px;
  }

  /* Ensure background colors print */
  .badge, .progress-bar {
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }
}

.print-header {
  display: none;
}
</style>

<main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <h3 class="mb-0">Monitoring Kelas: <?= $className ?></h3>
          </div>
          
          <?php if(session()->get('role') == 'admin' && !empty($allClasses)): ?>
          <div class="col-sm-6 text-end d-print-none">
             <form method="get" class="d-inline-block">
                <div class="input-group">
                   <label class="input-group-text bg-primary text-white">Pilih Kelas</label>
                   <select name="class_id" class="form-select" onchange="this.form.submit()">
                      <?php foreach($allClasses as $c): ?>
                         <option value="<?= $c['id'] ?>" <?= ($currentClassId == $c['id']) ? 'selected' : '' ?>>
                            <?= $c['name'] ?>
                         </option>
                      <?php endforeach; ?>
                   </select>
                </div>
             </form>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-outline card-primary mb-4">
            <div class="card-header">
                <h3 class="card-title">Rekapitulasi Siswa</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="window.print()">
                        <i class="bi bi-printer"></i> Cetak Laporan
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <div class="print-header">
                    <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 20px; border-bottom: 3px double black; padding-bottom: 10px;">
                        <?php if(!empty($institution['logo'])): ?>
                            <img src="<?= base_url('uploads/'.$institution['logo']) ?>" style="height: 100px; margin-right: 20px;" alt="Logo Sekolah">
                        <?php endif; ?>
                        <div style="text-align: center;">
                            <h2 style="margin: 0; font-weight: bold; text-transform: uppercase;"><?= $institution['school_name'] ?></h2>
                            <p style="margin: 5px 0; font-size: 14px;"><?= $institution['school_address'] ?></p>
                        </div>
                    </div>
                    
                    <h3 style="text-align: center; margin-bottom: 20px; text-decoration: underline;">LAPORAN MONITORING KEGIATAN RAMADHAN</h3>
                    
                    <table style="width: 100%; margin-bottom: 20px; border: none;">
                        <tr>
                            <td width="150">Kelas</td>
                            <td width="10">:</td>
                            <td><?= $className ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Cetak</td>
                            <td>:</td>
                            <td><?= date('d F Y') ?></td>
                        </tr>
                    </table>
                </div>
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Total Laporan</th>
                            <th>Disetujui</th>
                            <th>Ditolak</th>
                            <th>Persentase Kepatuhan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach($students as $student): ?>
                        <?php 
                            // Simple calculation: compliance based on approved vs total days (assuming 30 days ramadhan, but here just raw counts)
                            $compliance = ($student['total_logs'] > 0) ? round(($student['approved_logs'] / $student['total_logs']) * 100) : 0;
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $student['name'] ?></td>
                            <td><?= $student['total_logs'] ?></td>
                            <td><span class="badge text-bg-success"><?= $student['approved_logs'] ?></span></td>
                            <td><span class="badge text-bg-danger"><?= $student['rejected_logs'] ?></span></td>
                            <td>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $compliance ?>%" aria-valuenow="<?= $compliance ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small><?= $compliance ?>%</small>
                            </td>
                            <td>
                                <?php if($student['total_logs'] == 0): ?>
                                    <span class="badge text-bg-warning">Tidak Aktif</span>
                                <?php elseif($compliance < 50): ?>
                                    <span class="badge text-bg-warning">Kurang Disiplin</span>
                                <?php else: ?>
                                    <span class="badge text-bg-success">Baik</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="print-header" style="margin-top: 50px;">
                    <table style="width: 100%; text-align: center; border: none;">
                        <tr>
                            <td width="30%"></td>
                            <td width="40%"></td>
                            <td width="30%">
                                <p>Mengetahui,</p>
                                <p>Kepala Sekolah</p>
                                <br><br><br>
                                <p style="font-weight: bold; text-decoration: underline;"><?= $institution['headmaster_name'] ?></p>
                                <p>NIP. <?= $institution['headmaster_nip'] ?></p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
</main>

<?= view('layouts/footer') ?>
