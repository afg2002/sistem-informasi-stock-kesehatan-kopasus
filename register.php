
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register  | Sistem Aplikasi Manajemen Alkes</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="dist/css/sanspro.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    .image-container {
    display: flex;
    justify-content: center;
    align-items: center;
}
body {
    background-image: url("dist/images/background.jpeg");
    background-size: cover;
  }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
<div class="image-container">
<img src="dist/images/logo.png" width="200px" alt="" >
</div>
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index2.html" class="h1"><b>Sistem Informasi  </b>Stock Kesehatan Kopassus</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign up to register your account!</p>
      <!-- Tambahkan Alert Error Login -->

      <form action="db/proses-register.php" method="POST">
        <div class="input-group mb-3">
          <!-- Input for Full Name -->
          <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Full Name" name="full_name">
              <div class="input-group-append">
                  <div class="input-group-text">
                      <span class="fas fa-user-circle"></span>
                  </div>
              </div>
          </div>

          <input type="text" class="form-control" placeholder="Username" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
            <a href="index.php" class="btn btn-danger btn-block">Sudah punya akun?</a>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
