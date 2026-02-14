<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/sidebar') ?>

<main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3 class="mb-0">Edit Kegiatan Ramadhan</h3>
          </div>
        </div>
      </div>
    </div>

    <div class="app-content">
      <div class="container-fluid">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('validation')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('validation')->listErrors() ?></div>
        <?php endif; ?>

        <form action="<?= base_url('activity/update/' . $activity['id']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="date" value="<?= $activity['date'] ?>">
        <div class="row">
          <!-- Left Column -->
          <div class="col-md-6">
            <!-- Shalat 5 Waktu -->
            <div class="card card-success card-outline mb-4">
              <div class="card-header">
                <h3 class="card-title">Shalat 5 Waktu (Checklist)</h3>
              </div>
              <div class="card-body">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="shalat_subuh" value="1" id="subuh" <?= $activity['shalat_subuh'] ? 'checked' : '' ?>>
                  <label class="form-check-label" for="subuh">Subuh</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="shalat_dzuhur" value="1" id="dzuhur" <?= $activity['shalat_dzuhur'] ? 'checked' : '' ?>>
                  <label class="form-check-label" for="dzuhur">Dzuhur</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="shalat_ashar" value="1" id="ashar" <?= $activity['shalat_ashar'] ? 'checked' : '' ?>>
                  <label class="form-check-label" for="ashar">Ashar</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="shalat_maghrib" value="1" id="maghrib" <?= $activity['shalat_maghrib'] ? 'checked' : '' ?>>
                  <label class="form-check-label" for="maghrib">Maghrib</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="shalat_isya" value="1" id="isya" <?= $activity['shalat_isya'] ? 'checked' : '' ?>>
                  <label class="form-check-label" for="isya">Isya</label>
                </div>
              </div>
            </div>

            <!-- Tadarus -->
            <div class="card card-info card-outline mb-4">
              <div class="card-header">
                <h3 class="card-title">Tadarus Al-Qur'an</h3>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label">Nama Surat</label>
                  <input type="text" name="tadarus_surah" class="form-control" placeholder="Contoh: Al-Baqarah" value="<?= esc($activity['tadarus_surah']) ?>">
                </div>
                <div class="mb-3">
                  <label class="form-label">Ayat (Dari - Sampai)</label>
                  <input type="text" name="tadarus_ayat" class="form-control" placeholder="Contoh: 1-10" value="<?= esc($activity['tadarus_ayat']) ?>">
                </div>
              </div>
            </div>
          </div>

          <!-- Right Column -->
          <div class="col-md-6">
            <!-- Tarawih & Puasa -->
            <div class="card card-warning card-outline mb-4">
              <div class="card-header">
                <h3 class="card-title">Ibadah Utama (Wajib Foto)</h3>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label">Shalat Tarawih?</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tarawih" value="1" id="tarawih_ya" onclick="document.getElementById('tarawih_photo').style.display='block'" <?= $activity['tarawih'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="tarawih_ya">Ya</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tarawih" value="0" id="tarawih_tidak" onclick="document.getElementById('tarawih_photo').style.display='none'" <?= !$activity['tarawih'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="tarawih_tidak">Tidak</label>
                  </div>
                  <div class="mt-2" id="tarawih_photo" style="<?= $activity['tarawih'] ? 'display:block;' : 'display:none;' ?>">
                    <label class="form-label">Upload Foto Tarawih</label>
                    <?php if(!empty($activity['tarawih_photo'])): ?>
                        <div class="mb-2">
                            <img src="<?= base_url('uploads/activities/'.$activity['tarawih_photo']) ?>" class="img-thumbnail" width="150">
                            <small class="d-block text-muted">Foto saat ini</small>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="tarawih_photo" class="form-control">
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Puasa?</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="puasa" value="1" id="puasa_ya" onclick="document.getElementById('puasa_photo').style.display='block'" <?= $activity['puasa'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="puasa_ya">Ya</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="puasa" value="0" id="puasa_tidak" onclick="document.getElementById('puasa_photo').style.display='none'" <?= !$activity['puasa'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="puasa_tidak">Tidak</label>
                  </div>
                  <div class="mt-2" id="puasa_photo" style="<?= $activity['puasa'] ? 'display:block;' : 'display:none;' ?>">
                    <label class="form-label">Upload Foto Sahur/Buka</label>
                    <?php if(!empty($activity['puasa_photo'])): ?>
                        <div class="mb-2">
                            <img src="<?= base_url('uploads/activities/'.$activity['puasa_photo']) ?>" class="img-thumbnail" width="150">
                            <small class="d-block text-muted">Foto saat ini</small>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="puasa_photo" class="form-control">
                  </div>
                </div>
              </div>
            </div>

            <!-- Kultum -->
            <div class="card card-secondary card-outline mb-4">
              <div class="card-header">
                <h3 class="card-title">Kultum / Ceramah</h3>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label">Judul Materi</label>
                  <input type="text" name="kultum_judul" class="form-control" placeholder="Judul ceramah" value="<?= esc($activity['kultum_judul']) ?>">
                </div>
                <div class="mb-3">
                  <label class="form-label">Nama Penceramah</label>
                  <input type="text" name="kultum_penceramah" class="form-control" placeholder="Nama Ustadz/Ustadzah" value="<?= esc($activity['kultum_penceramah']) ?>">
                </div>
                <div class="mb-3">
                  <label class="form-label">Jenis</label>
                  <select name="kultum_type" class="form-select">
                    <option value="offline" <?= $activity['kultum_type'] == 'offline' ? 'selected' : '' ?>>Offline (Masjid/Musholla)</option>
                    <option value="online" <?= $activity['kultum_type'] == 'online' ? 'selected' : '' ?>>Online (YouTube/TV)</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 mb-4">
            <button type="submit" class="btn btn-warning btn-lg w-100">Update Laporan</button>
            <a href="<?= base_url('activity') ?>" class="btn btn-secondary w-100 mt-2">Batal</a>
          </div>
        </div>
        </form>
      </div>
    </div>
</main>

<?= view('layouts/footer') ?>