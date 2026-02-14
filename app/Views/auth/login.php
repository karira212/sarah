<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SARAH | Log in</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
  
  <!-- OverlayScrollbars -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" integrity="sha256-wN66Utf+Q1+5Mr5vO2bS2tQ3a968p41/Z6Q5rQ+9xXw=" crossorigin="anonymous">
  
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WPRiWrr9DJRBrxnOYPKBXyM986GZq0=" crossorigin="anonymous">
  
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css') ?>">
</head>
<body class="login-page bg-body-secondary">
<div class="login-box">
  <div class="login-logo text-center">
    <a href="#" class="d-block text-decoration-none">
      <i class="bi bi-moon-stars-fill text-warning display-4"></i>
      <br>
      <span class="fw-bold display-5">SARAH</span>
    </a>
    <div class="fs-5 text-muted">Sahabat Ramadhan</div>
  </div>
  <!-- /.login-logo -->
  <div class="card card-outline card-primary shadow-sm">
    <div class="card-body">
      <p class="login-box-msg">Silakan masuk untuk memulai</p>

      <?php if(session()->getFlashdata('msg')):?>
        <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
      <?php endif;?>

      <form action="<?= base_url('/auth/processLogin') ?>" method="post">
        <div class="input-group mb-3">
          <div class="form-floating">
            <input type="text" name="username" class="form-control" id="loginUsername" placeholder="Username" required>
            <label for="loginUsername">Username</label>
          </div>
          <span class="input-group-text"><i class="bi bi-person text-dark"></i></span>
        </div>
        <div class="input-group mb-3">
          <div class="form-floating">
            <input type="password" name="password" class="form-control" id="loginPassword" placeholder="Password" required>
            <label for="loginPassword">Password</label>
          </div>
          <span class="input-group-text" role="button" id="togglePassword">
            <i class="bi bi-eye text-dark"></i>
          </span>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
              <label class="form-check-label" for="flexCheckDefault">
                Ingat Saya
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">Masuk</button>
            </div>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- OverlayScrollbars -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha256-CDOy6cOibCWEdsRiZuaHf8dSGGJRYuBGC+mjoJimHGw=" crossorigin="anonymous"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('adminlte/dist/js/adminlte.min.js') ?>"></script>
<script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#loginPassword');

  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.querySelector('i').classList.toggle('bi-eye');
    this.querySelector('i').classList.toggle('bi-eye-slash');
  });
</script>
</body>
</html>
