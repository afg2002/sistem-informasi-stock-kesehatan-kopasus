<?php

require_once 'template/header.php';


// Menghitung jumlah data pada tabel Obat
$sqlObat = "SELECT COUNT(*) as totalObat, MAX(tanggal) as lasttanggalObat FROM Obat";
$resultObat = $conn->query($sqlObat);
$rowObat = $resultObat->fetch_assoc();
$totalObat = $rowObat['totalObat'];


// Menghitung jumlah data pada tabel Alkes
$sqlAlkes = "SELECT COUNT(*) as totalAlkes, MAX(tanggal) as lasttanggalAlkes FROM Alkes";
$resultAlkes = $conn->query($sqlAlkes);
$rowAlkes = $resultAlkes->fetch_assoc();
$totalAlkes = $rowAlkes['totalAlkes'];

// Menghitung jumlah data pada tabel Kendaraan
$sqlKendaraan = "SELECT COUNT(*) as totalKendaraan, MAX(timestamp) as lasttanggalKendaraan FROM Kendaraan";
$resultKendaraan = $conn->query($sqlKendaraan);
$rowKendaraan = $resultKendaraan->fetch_assoc();
$totalKendaraan = $rowKendaraan['totalKendaraan'];

// Menghitung jumlah data pada tabel Pengguna
$sqlUsers = "SELECT COUNT(*) as totalUsers FROM user"; // Gantilah "Pengguna" dengan nama tabel yang sesuai
$resultUsers = $conn->query($sqlUsers);
$rowUsers = $resultUsers->fetch_assoc();
$totalUsers = $rowUsers['totalUsers'];


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
          <img class="banner-image" src="dist/images/background.jpeg" alt="Banner Image">
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-pills fa-fw"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Data Obat</span>
                    <span class="info-box-number"><?php echo $totalObat; ?></span>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="chartObat"></canvas>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-medkit fa-fw"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Data Alkes</span>
                    <span class="info-box-number"><?php echo $totalAlkes; ?></span>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="chartAlkes"></canvas>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-car fa-fw"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Data Kendaraan</span>
                    <span class="info-box-number"><?php echo $totalKendaraan; ?></span>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="chartKendaraan"></canvas>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-users fa-fw"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Data Pengguna</span>
                    <span class="info-box-number"><?php echo $totalUsers; ?></span>
                </div>
            </div>
        </div>

    </div>
</div>


<?php
require_once 'template/footer.php'; 
?>