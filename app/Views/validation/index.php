<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/sidebar') ?>

<main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <h3 class="mb-0">Validasi Ibadah Siswa</h3>
          </div>
          <div class="col-sm-6 text-end">
             <form method="get" class="d-inline-block">
                <div class="input-group">
                   <label class="input-group-text bg-primary text-white">Filter Kelas</label>
                   <select name="class_id" class="form-select" onchange="this.form.submit()">
                      <option value="">Semua Kelas</option>
                      <?php foreach($classes as $c): ?>
                         <option value="<?= $c['id'] ?>" <?= ($currentClassId == $c['id']) ? 'selected' : '' ?>>
                            <?= $c['name'] ?>
                         </option>
                      <?php endforeach; ?>
                   </select>
                </div>
             </form>
          </div>
        </div>
      </div>
    </div>

    <div class="app-content">
      <div class="container-fluid">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <h3 class="card-title">Daftar Kegiatan Pending</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Tarawih</th>
                            <th>Puasa</th>
                            <th>Tadarus</th>
                            <th>Kultum</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($activities)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">Tidak ada kegiatan yang perlu diverifikasi saat ini.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($activities as $activity): ?>
                            <tr>
                                <td><?= $activity['date'] ?></td>
                            <td><?= $activity['student_name'] ?></td>
                            <td><span class="badge text-bg-light border text-dark"><?= $activity['class_name'] ?? '-' ?></span></td>
                            <td>
                                <?php if($activity['tarawih']): ?>
                                    <span class="badge text-bg-success">Ya</span>
                                    <?php if($activity['tarawih_photo']): ?>
                                        <a href="<?= base_url('uploads/activities/'.$activity['tarawih_photo']) ?>" target="_blank" class="btn btn-xs btn-info"><i class="bi bi-image"></i> Foto</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge text-bg-secondary">Tidak</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($activity['puasa']): ?>
                                    <span class="badge text-bg-success">Ya</span>
                                    <?php if($activity['puasa_photo']): ?>
                                        <a href="<?= base_url('uploads/activities/'.$activity['puasa_photo']) ?>" target="_blank" class="btn btn-xs btn-info"><i class="bi bi-image"></i> Foto</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge text-bg-secondary">Tidak</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($activity['tadarus_surah']): ?>
                                    <?= $activity['tadarus_surah'] ?> (<?= $activity['tadarus_ayat'] ?>)
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($activity['kultum_judul']): ?>
                                    <?= $activity['kultum_judul'] ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-verify-<?= $activity['id'] ?>">
                                    Verifikasi
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="modal-verify-<?= $activity['id'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="<?= base_url('validation/update') ?>" method="post">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Verifikasi Kegiatan</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $activity['id'] ?>">
                                            <p><strong>Siswa:</strong> <?= $activity['student_name'] ?></p>
                                            <p><strong>Tanggal:</strong> <?= $activity['date'] ?></p>
                                            
                                            <div class="mb-3">
                                                <label>Status</label>
                                                <select name="status" class="form-select">
                                                    <option value="approved">Setujui</option>
                                                    <option value="rejected">Tolak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>Catatan Guru (Opsional)</label>
                                                <textarea name="teacher_note" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
