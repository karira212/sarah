<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/sidebar') ?>

<main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <h3 class="mb-0">Daftar Nilai Harian</h3>
          </div>
          <div class="col-sm-6">
             <form method="get" class="row g-2 justify-content-end d-print-none">
                <div class="col-auto">
                    <input type="date" name="date" class="form-control" value="<?= $currentDate ?>" onchange="this.form.submit()">
                </div>
                <div class="col-auto">
                   <select name="class_id" class="form-select" onchange="this.form.submit()">
                      <option value="">Semua Kelas</option>
                      <?php foreach($classes as $c): ?>
                         <option value="<?= $c['id'] ?>" <?= ($currentClassId == $c['id']) ? 'selected' : '' ?>>
                            <?= $c['name'] ?>
                         </option>
                      <?php endforeach; ?>
                   </select>
                </div>
                <div class="col-auto">
                    <a class="btn btn-success" href="<?= base_url('grades/export') . '?' . http_build_query(['date' => $currentDate, 'class_id' => $currentClassId]) ?>">
                        <i class="bi bi-file-earmark-excel"></i> Export Nilai (Excel)
                    </a>
                </div>
             </form>
          </div>
        </div>
      </div>
    </div>

    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title">Rekap Nilai Tanggal: <?= date('d F Y', strtotime($currentDate)) ?></h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped align-middle">
                    <thead>
                        <tr>
                            <th style="width: 50px">No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th class="text-center">Shalat (5)</th>
                            <th class="text-center">Tarawih</th>
                            <th class="text-center">Puasa</th>
                            <th class="text-center">Tadarus</th>
                            <th class="text-center">Kultum</th>
                            <th class="text-center">Nilai</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($activities)): ?>
                            <tr>
                                <td colspan="10" class="text-center py-4">Tidak ada data kegiatan untuk tanggal ini.</td>
                            </tr>
                        <?php else: ?>
                            <?php $i = 1; foreach($activities as $activity): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $activity['student_name'] ?></td>
                                <td><span class="badge text-bg-light border text-dark"><?= $activity['class_name'] ?? '-' ?></span></td>
                                <td class="text-center">
                                    <?php 
                                        $shalatCount = 0;
                                        if($activity['shalat_subuh']) $shalatCount++;
                                        if($activity['shalat_dzuhur']) $shalatCount++;
                                        if($activity['shalat_ashar']) $shalatCount++;
                                        if($activity['shalat_maghrib']) $shalatCount++;
                                        if($activity['shalat_isya']) $shalatCount++;
                                    ?>
                                    <span class="badge <?= $shalatCount == 5 ? 'text-bg-success' : 'text-bg-warning' ?>"><?= $shalatCount ?>/5</span>
                                </td>
                                <td class="text-center">
                                    <?php if($activity['tarawih']): ?>
                                        <span class="badge text-bg-success">Ya</span>
                                    <?php else: ?>
                                        <span class="badge text-bg-danger">Tidak</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($activity['puasa']): ?>
                                        <span class="badge text-bg-success">Ya</span>
                                    <?php else: ?>
                                        <span class="badge text-bg-danger">Tidak</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if(!empty($activity['tadarus_surah'])): ?>
                                        <span class="badge text-bg-success">Ada</span>
                                    <?php else: ?>
                                        <span class="badge text-bg-secondary">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if(!empty($activity['kultum_judul'])): ?>
                                        <span class="badge text-bg-success">Ada</span>
                                    <?php else: ?>
                                        <span class="badge text-bg-secondary">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="fs-5 fw-bold <?= $activity['calculated_score'] == 100 ? 'text-success' : 'text-primary' ?>">
                                        <?= $activity['calculated_score'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if($activity['status'] == 'approved'): ?>
                                        <span class="badge text-bg-success">Valid</span>
                                    <?php elseif($activity['status'] == 'rejected'): ?>
                                        <span class="badge text-bg-danger">Ditolak</span>
                                    <?php else: ?>
                                        <span class="badge text-bg-secondary">Pending</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
</main>

<style>
@media print {
    .d-print-none, .app-header, .app-sidebar, .app-footer {
        display: none !important;
    }
    .app-wrapper, .app-main { 
        margin: 0 !important; 
        padding: 0 !important;
        width: 100% !important;
        background-color: white !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>

<?= view('layouts/footer') ?>
