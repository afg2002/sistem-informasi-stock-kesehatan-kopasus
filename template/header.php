<?php 
require_once 'db/helper.php'; 

session_start();
// if session is not set then redirect to login page
if (!isset($_SESSION['username'])) {
  header("Location: index.php?notA=1");
  exit();
}


// Mendapatkan nama file saat ini
$current_page = basename($_SERVER['PHP_SELF']);

// Daftar nama file dan judul yang sesuai
$pages = array(
    'dashboard.php' => 'Dashboard',
    'obat.php' => 'Obat',
    'penerimaan_obat.php' => 'Penerimaan Obat',
    'pengeluaran_obat.php' => 'Pengeluaran Obat',
    'kendaraan.php' => 'Kendaraan',
    'alkes.php' => 'Alat Kesehatan',
    
    // Tambahkan nama file dan judul lainnya sesuai kebutuhan
);

// Set judul halaman sesuai dengan nama file saat ini
$page_title = isset($pages[$current_page]) ? $pages[$current_page] : 'Halaman Tidak Ditemukan';


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Informasi Stock Kesehatan Kopassus | <?php echo $page_title; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="dist/css/sanspro.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="dist/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Tambahkan CSS untuk mengatur latar belakang -->
  <style>
    .banner-image {
    background-image: url('dist/images/background.jpeg');
    background-size: auto 100%;
    background-repeat: no-repeat;
    background-position: center;
    max-height: 300px; /* Maksimum tinggi elemen */
    width: 100%; /* Lebar elemen mengikuti aspek rasio gambar */
}

    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/images/logo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Profile Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Profile
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
        <a class="dropdown-item" href="profile.php">Edit Profile</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="db/logout.php">Logout</a>
      </div>
    </li>
  </ul>
</nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 bg-danger" >
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/images/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light" style="font-size: 10px">Sistem Informasi Stock Kesehatan Kopassus</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['full_name']; ?></a>
        </div>
      </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Menu Dashboard -->
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            
            <!-- Menu Obat -->
            <li class="nav-item">
                <a href="obat.php" class="nav-link">
                    <i class="nav-icon fas fa-pills"></i>
                    <p>Obat</p>
                </a>
            </li>
            
            <!-- Menu Alkes -->
            <li class="nav-item">
                <a href="alkes.php" class="nav-link">
                    <i class="nav-icon fas fa-medkit"></i>
                    <p>Alkes</p>
                </a>
            </li>
            
            <!-- Menu Kendaraan -->
            <li class="nav-item">
                <a href="kendaraan.php" class="nav-link">
                    <i class="nav-icon fas fa-car"></i>
                    <p>Kendaraan</p>
                </a>
            </li>

            
            <!-- Menu Users Tampiil Hanya Operator -->
            <?php 
              if ($_SESSION['role'] == 'operator') {

            ?>
            <li class="nav-item">
                <a href="users.php" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Users</p>
                </a>
            </li>
            <?php } ?>
        </ul>

    </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
