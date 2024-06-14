<?php

require 'koneksi.php';

global $conn;

function getAlkesData()
{
    global $conn;
    $sql = "SELECT alkes.*, kategori_alkes.nama_kategori, kondisi.nama_kondisi
            FROM alkes
            INNER JOIN kategori_alkes ON alkes.kategori_id = kategori_alkes.id
            INNER JOIN kondisi ON alkes.kondisi_id = kondisi.id";
    $result = $conn->query($sql);
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}


// Function to get category names from the database
function getNamaKategoriAlkes()
{
    global $conn;

    $sql = "SELECT id, nama_kategori FROM kategori_alkes";
    $result = $conn->query($sql);

    $kategoriNames = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $kategoriNames[$row['id']] = $row['nama_kategori'];
        }
    }

    return $kategoriNames;
}

function getNamaKondisi() {
    global $conn;
    $sql = "SELECT * FROM kondisi";
    $result = mysqli_query($conn, $sql);

    $kondisi = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $kondisi[] = $row;
    }
    return $kondisi;
}



function getDataAlkesByNamaKategori($namaKategori)
{
    global $conn;
    // Menghindari SQL Injection dengan menggunakan parameterized query
    $sql = "SELECT alkes.*, kategori_alkes.nama_kategori, kondisi.*
            FROM alkes
            INNER JOIN kategori_alkes ON alkes.kategori_id = kategori_alkes.id
            INNER JOIN kondisi ON alkes.kondisi_id = kondisi.id
            WHERE kategori_alkes.nama_kategori = ?";
    
    // Persiapkan statement SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $namaKategori); // Mengikat parameter untuk menghindari SQL Injection
    $stmt->execute();
    
    $result = $stmt->get_result();
    $data = array();
    
    // Ambil data dari hasil query
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    return $data;
}

function getDataAlkesByNamaKondisi($kondisi)
{
    global $conn;
    // Menghindari SQL Injection dengan menggunakan parameterized query
    $sql = "SELECT alkes.*, kategori_alkes.nama_kategori, kondisi.*
            FROM alkes
            INNER JOIN kategori_alkes ON alkes.kategori_id = kategori_alkes.id
            INNER JOIN kondisi ON alkes.kondisi_id = kondisi.id
            WHERE kondisi.nama_kondisi = ?";
    
    // Persiapkan statement SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $kondisi); // Mengikat parameter untuk menghindari SQL Injection
    $stmt->execute();
    
    $result = $stmt->get_result();
    $data = array();
    
    // Ambil data dari hasil query
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    return $data;
}





// Fungsi untuk mendapatkan data Alkes berdasarkan ID dari database
function getAlkesById($id)
{
    global $conn;
    $sql = "SELECT * FROM Alkes WHERE id=$id";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

function addAlkes($namaMateril, $merk_type, $satuan, $kondisi_id, $keterangan, $kategoriId)
{
    global $conn;
    $sql = "INSERT INTO alkes (nama_materil, merk_type, satuan, kondisi_id, keterangan, kategori_id)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiss", $namaMateril, $merk_type, $satuan, $kondisi_id, $keterangan, $kategoriId);
    $result =  $stmt->execute();
    $stmt->close();
    if ($result) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "Data Alkes berhasil ditambahkan."
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Gagal menambahkan data Alkes. Silakan coba lagi."
        ];
    }
}


function updateAlkesData($id, $namaMateri, $merkType, $satuan, $kondisi,$keterangan, $kategoriId) {
    global $conn;
    $sql = "UPDATE alkes
            SET nama_materil = ?, merk_type = ?, satuan = ?, kondisi_id = ?, keterangan = ?, kategori_id = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiisi", $namaMateril, $merk_type, $satuan, $kondisi_id, $keterangan, $kategoriId, $id);
    $result =  $stmt->execute();
    $stmt->close();

    if ($result) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "Data Alkes berhasil diperbarui."
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Gagal memperbarui data Alkes. Silakan coba lagi."
        ];
    }

    return $result;
}

function deleteAlkesData($id) {
    global $conn;
    $sql = "DELETE FROM alkes WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "Data Alkes berhasil dihapus."
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Gagal menghapus data Alkes. Silakan coba lagi."
        ];
    }

    return $result;
}

function addKendaraan($namaKendaraan, $jenis, $bbm, $jumlah, $keterangan) {
    global $conn;
    $sql = "INSERT INTO kendaraan (nama_kendaraan, jenis, bbm, jumlah, keterangan) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $namaKendaraan, $jenis, $bbm, $jumlah, $keterangan);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "Data Kendaraan berhasil ditambahkan."
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Gagal menambahkan data Kendaraan. Silakan coba lagi."
        ];
    }

    return $result;
}

function updateKendaraanData($id, $namaKendaraan, $jenis, $bbm, $jumlah, $keterangan) {
    global $conn;
    $sql = "UPDATE kendaraan SET nama_kendaraan=?, jenis=?, bbm=?, jumlah=?, keterangan=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $namaKendaraan, $jenis, $bbm, $jumlah, $keterangan, $id);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "Data Kendaraan berhasil diperbarui."
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Gagal memperbarui data Kendaraan. Silakan coba lagi."
        ];
    }

    return $result;
}

function deleteKendaraanData($id) {
    global $conn;
    $sql = "DELETE FROM kendaraan WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "Data Kendaraan berhasil dihapus."
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Gagal menghapus data Kendaraan. Silakan coba lagi."
        ];
    }

    return $result;
}

function getKendaraanData() {
    global $conn;
    $sql = "SELECT * FROM kendaraan";
    $result = mysqli_query($conn, $sql); // Added $conn here

    $kendaraanData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $kendaraanData[] = $row;
    }

    return $kendaraanData;
}

// Fungsi untuk mendapatkan semua data obat
function getObatData()
{
    global $conn;
    $sql = "SELECT * FROM obat";
    $result = $conn->query($sql);

    $obatData = [];
    while ($row = $result->fetch_assoc()) {
        $obatData[] = $row;
    }

    return $obatData;
}

// Fungsi untuk menambahkan data obat
function addObat($tanggal, $namaObat, $merk, $jumlah, $jenis, $keterangan,$id_kategori_obat)
{
    global $conn;
    $sql = "INSERT INTO obat (tanggal, nama_obat, merk, jumlah, jenis, keterangan,id_kategori_obat) VALUES (?, ?, ?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisss", $tanggal, $namaObat, $merk, $jumlah, $jenis, $keterangan,$id_kategori_obat);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "Data Obat berhasil ditambahkan."
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Gagal menambahkan data Obat. Silakan coba lagi."
        ];
    }

    return $result;
}

// Function to update drug data
function updateObatData($id, $tanggal, $namaObat, $merk, $jumlah, $jenis, $keterangan, $id_kategori_obat)
{
    global $conn;
    $sql = "UPDATE obat SET tanggal=?, nama_obat=?, merk=?, jumlah=?, jenis=?, keterangan=?, id_kategori_obat=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissii", $tanggal, $namaObat, $merk, $jumlah, $jenis, $keterangan, $id_kategori_obat, $id);
    $result = $stmt->execute();
    $stmt->close();

    $flashMessage = $result ? "Data Obat berhasil diperbarui." : "Gagal memperbarui data Obat. Silakan coba lagi.";
    $_SESSION['flash_message'] = [
        'type' => $result ? 'success' : 'danger',
        'message' => $flashMessage
    ];



    return $result;
}
// Fungsi untuk menghapus data obat berdasarkan ID
function deleteObatData($id)
{
    global $conn;
    $sql = "DELETE FROM obat WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => "Data Obat berhasil dihapus."
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => "Gagal menghapus data Obat. Silakan coba lagi."
        ];
    }

    return $result;
}

function getObatByCategory($nama_kategori) {
    global $conn;
    $sql = "SELECT obat.*, kategori_obat.nama_kategori 
            FROM obat 
            INNER JOIN kategori_obat ON obat.id_kategori_obat = kategori_obat.id 
            WHERE kategori_obat.nama_kategori = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nama_kategori);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function getAnalgetikData() {
    return getObatByCategory("ANALGETIK/ANTIPRETIK");
}

function getAntibioticData() {
    return getObatByCategory("ANTIBIOTIC");
}

function getGigiData() {
    return getObatByCategory("GIGI");
}

function getReagentLabData() {
    return getObatByCategory("REAGENT LAB");
}

function getKategoriObatData() {
    global $conn;
    $sql = "SELECT * FROM kategori_obat";
    $result = mysqli_query($conn, $sql);

    $kategoriObatData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $kategoriObatData[] = $row;
    }

    return $kategoriObatData;
}


function getKategoriAlkesData() {
    global $conn;
    $sql = "SELECT * FROM kategori_alkes";
    $result = mysqli_query($conn, $sql);

    $kategoriAlkesData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $kategoriAlkesData[] = $row;
    }
    return $kategoriAlkesData;
}
    

// Fungsi untuk mendapatkan data penerimaan obat beserta nama obat
function getPenerimaanObatDataAnalgetik()
{
    global $conn;
    $sql = "SELECT penerimaan_obat.*, obat.nama_obat 
            FROM penerimaan_obat 
            INNER JOIN obat ON penerimaan_obat.id_obat = obat.id 
            INNER JOIN kategori_obat on kategori_obat.id = obat.id_kategori_obat
            WHERE kategori_obat.nama_kategori = 'ANALGETIK/ANTIPRETIK'
            ";
    $result = $conn->query($sql);

    $penerimaanObatData = [];
    while ($row = $result->fetch_assoc()) {
        $penerimaanObatData[] = $row;
    }

    return $penerimaanObatData;
}
// Fungsi untuk mendapatkan data penerimaan obat beserta nama obat
function getPenerimaanObatDataAntibiotic()
{
    global $conn;
    $sql = "SELECT penerimaan_obat.*, obat.nama_obat 
            FROM penerimaan_obat 
            INNER JOIN obat ON penerimaan_obat.id_obat = obat.id 
            INNER JOIN kategori_obat on kategori_obat.id = obat.id_kategori_obat
            WHERE kategori_obat.nama_kategori = 'ANTIBIOTIC'
            ";
    $result = $conn->query($sql);

    $penerimaanObatData = [];
    while ($row = $result->fetch_assoc()) {
        $penerimaanObatData[] = $row;
    }

    return $penerimaanObatData;
}
function getPenerimaanObatDataGigi()
{
    global $conn;
    $sql = "SELECT penerimaan_obat.*, obat.nama_obat 
            FROM penerimaan_obat 
            INNER JOIN obat ON penerimaan_obat.id_obat = obat.id 
            INNER JOIN kategori_obat on kategori_obat.id = obat.id_kategori_obat
            WHERE kategori_obat.nama_kategori = 'GIGI'
            ";
    $result = $conn->query($sql);

    $penerimaanObatData = [];
    while ($row = $result->fetch_assoc()) {
        $penerimaanObatData[] = $row;
    }

    return $penerimaanObatData;
}
function getPenerimaanObatDataReagentLab()
{
    global $conn;
    $sql = "SELECT penerimaan_obat.*, obat.nama_obat 
            FROM penerimaan_obat 
            INNER JOIN obat ON penerimaan_obat.id_obat = obat.id 
            INNER JOIN kategori_obat on kategori_obat.id = obat.id_kategori_obat
            WHERE kategori_obat.nama_kategori = 'REAGENT LAB'
            ";
    $result = $conn->query($sql);

    $penerimaanObatData = [];
    while ($row = $result->fetch_assoc()) {
        $penerimaanObatData[] = $row;
    }

    return $penerimaanObatData;
}

// Fungsi untuk update data penerimaan obat
function updateDataPenerimaanObat($id,$tanggal,$idObat,$stok_masuk) {
    global $conn;
    // Update query
    $sql = "UPDATE penerimaan_obat SET tanggal='$tanggal', id_obat='$idObat', stok_masuk='$stok_masuk' WHERE id='$id'";
    $result = $conn->query($sql);

    return $result;
}

// Fungsi untuk pengeluaran obat analgetic atau antipretik 
function getPengeluaranObatDataAnalgetik() {
    global $conn;
    $sql = "SELECT pengeluaran_obat.*, obat.nama_obat 
            FROM pengeluaran_obat 
            INNER JOIN obat ON pengeluaran_obat.id_obat = obat.id 
            INNER JOIN kategori_obat on kategori_obat.id = obat.id_kategori_obat
            WHERE kategori_obat.nama_kategori = 'ANALGETIK/ANTIPRETIK'
            ";
    $result = $conn->query($sql);
    return $result;
}

// Fungsi untuk pengeluaran obat antibiotic
function getPengeluaranObatDataAntibiotic() {
    global $conn;
    $sql = "SELECT pengeluaran_obat.*, obat.nama_obat 
            FROM pengeluaran_obat 
            INNER JOIN obat ON pengeluaran_obat.id_obat = obat.id 
            INNER JOIN kategori_obat on kategori_obat.id = obat.id_kategori_obat
            WHERE kategori_obat.nama_kategori = 'ANTIBIOTIC'
            ";
    $result = $conn->query($sql);
    return $result;
}

// Fungsi untuk pengeluaran obat gigi
function getPengeluaranObatDataGigi() {
    global $conn;
    $sql = "SELECT pengeluaran_obat.*, obat.nama_obat 
            FROM pengeluaran_obat 
            INNER JOIN obat ON pengeluaran_obat.id_obat = obat.id 
            INNER JOIN kategori_obat on kategori_obat.id = obat.id_kategori_obat
            WHERE kategori_obat.nama_kategori = 'GIGI'
            ";
    $result = $conn->query($sql);
    return $result;
}

// Fungsi untuk pengeluaran obat reagent lab
function getPengeluaranObatDataReagentLab() {
    global $conn;
    $sql = "SELECT pengeluaran_obat.*, obat.nama_obat 
            FROM pengeluaran_obat 
            INNER JOIN obat ON pengeluaran_obat.id_obat = obat.id 
            INNER JOIN kategori_obat on kategori_obat.id = obat.id_kategori_obat
            WHERE kategori_obat.nama_kategori = 'REAGENT LAB'
            ";
    $result = $conn->query($sql);
    return $result;
}

// Fungsi untuk mengupdate data pengeluaran obat
function updateDataPengeluaranObat($id,$tanggal,$idObat,$stok_keluar) {
    global $conn;
    // Update query
    $sql = "UPDATE pengeluaran_obat SET tanggal='$tanggal', id_obat='$idObat', stok_keluar='$stok_keluar' WHERE id='$id'";
    $result = $conn->query($sql);

    return $result;
}

// Fungsi untuk menghapus data pengeluaran obat
function deleteDataPengeluaranObat($id) {
    global $conn;
    $sql = "DELETE FROM pengeluaran_obat WHERE id='$id'";
    $result = $conn->query($sql);

    return $result;
}

// Fungsi untuk mendapatkan data user
function getUserData() {
    global $conn;
    $sql = "SELECT * FROM user";
    $result = $conn->query($sql);
    
    return $result;
}

function addUser($username, $password, $role, $full_name) {
    global $conn;
    $sql = "INSERT INTO user (username, password,role, full_name) VALUES ('$username', '$password', '$role', '$full_name')";
    $result = $conn->query($sql);

    return $result;
}

function deleteUser($id) {
    global $conn;
    $sql = "DELETE FROM user WHERE id='$id'";
    $result = $conn->query($sql);

    return $result;
}

//Update User
function updateUser($id, $username, $password, $role, $full_name) {
    global $conn;
    
    // Cek apakah password dikosongkan
    if (empty($password)) {
        $sql = "UPDATE user SET username='$username', role='$role', full_name='$full_name' WHERE id='$id'";
    } else {
        // Jika password tidak kosong, termasuk pembaruan password
        $sql = "UPDATE user SET username='$username', password='$password', role='$role', full_name='$full_name' WHERE id='$id'";
    }
    
    $result = $conn->query($sql);

    return $result;
}


