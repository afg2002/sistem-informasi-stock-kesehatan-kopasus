<?php
// Konfigurasi database
$host = 'localhost'; // Ganti dengan nama host database Anda
$database = 'db_kesehatan'; // Ganti dengan nama database Anda
$username = 'root'; // Ganti dengan username pengguna database Anda
$password = ''; // Ganti dengan kata sandi pengguna database Anda

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

?>