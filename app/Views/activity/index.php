<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/sidebar') ?>

<main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3 class="mb-0">Riwayat Kegiatan Saya</h3>
          </div>
          <div class="col-sm-6">
            <div class="float-sm-end">
                <a href="<?= base_url('activity/create') ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Kegiatan
                </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Daftar Laporan Kegiatan</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Shalat Wajib</th>
                            <th>Puasa</th>
                            <th>Tarawih</th>
                            <th>Tadarus</th>
                            <th>Status</th>
                            <th>Persentase</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($activities)): ?>
                            <tr>
                                <td colspan="7" class="text-center">Belum ada kegiatan yang dilaporkan.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($activities as $activity): ?>
                                <tr>
                                    <td><?= date('d M Y', strtotime($activity['date'])) ?></td>
                                    <td>
                                        <?php 
                                            $shalatCount = 0;
                                            if($activity['shalat_subuh']) $shalatCount++;
                                            if($activity['shalat_dzuhur']) $shalatCount++;
                                            if($activity['shalat_ashar']) $shalatCount++;
                                            if($activity['shalat_maghrib']) $shalatCount++;
                                            if($activity['shalat_isya']) $shalatCount++;
                                            echo $shalatCount . '/5';
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($activity['puasa']): ?>
                                            <span class="badge text-bg-success">Ya</span>
                                        <?php else: ?>
                                            <span class="badge text-bg-danger">Tidak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($activity['tarawih']): ?>
                                            <span class="badge text-bg-success">Ya</span>
                                        <?php else: ?>
                                            <span class="badge text-bg-danger">Tidak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(!empty($activity['tadarus_surah'])): ?>
                                            <?= $activity['tadarus_surah'] ?> : <?= $activity['tadarus_ayat'] ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($activity['status'] == 'approved'): ?>
                                            <span class="badge text-bg-success">Disetujui</span>
                                        <?php elseif($activity['status'] == 'rejected'): ?>
                                            <span class="badge text-bg-danger">Ditolak</span>
                                        <?php else: ?>
                                            <span class="badge text-bg-warning">Menunggu</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                            // Calculate completion percentage
                                            if ($activity['status'] == 'rejected') {
                                                $percentage = 50;
                                            } else {
                                                $totalItems = 9; // 5 shalat + tarawih + puasa + tadarus + kultum
                                                $filled = 0;
                                                if ($activity['shalat_subuh']) $filled++;
                                                if ($activity['shalat_dzuhur']) $filled++;
                                                if ($activity['shalat_ashar']) $filled++;
                                                if ($activity['shalat_maghrib']) $filled++;
                                                if ($activity['shalat_isya']) $filled++;
                                                if ($activity['tarawih']) $filled++;
                                                if ($activity['puasa']) $filled++;
                                                if (!empty($activity['tadarus_surah'])) $filled++;
                                                if (!empty($activity['kultum_judul'])) $filled++;
                                                
                                                $percentage = round(($filled / $totalItems) * 100);
                                            }
                                        ?>
                                        <div class="progress" style="height: 10px; width: 80px;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small><?= $percentage ?>%</small>
                                    </td>
                                    <td>
                                        <?php if($activity['date'] == date('Y-m-d') && $activity['status'] == 'pending'): ?>
                                            <a href="<?= base_url('activity/edit/'.$activity['id']) ?>" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                        <?php else: ?>
                                            <span class="badge text-bg-secondary" title="Terkunci"><i class="bi bi-lock-fill"></i></span>
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

<?= view('layouts/footer') ?>
