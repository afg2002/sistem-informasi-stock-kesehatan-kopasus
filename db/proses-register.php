<?php
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];

    // Check if the username already exists in the database
    $stmt = $conn->prepare("SELECT id FROM user WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<script>alert('Username sudah ada, silakan pilih yang lain.');</script>";
        echo "<script>window.location.href = '../register.php?error=1';</script>";
        exit();
    }

    // Validation
    if (empty($username) || empty($password) || empty($full_name)) {
        die("All fields are required!");
    }

    // Hashing the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO user (username, password, full_name,role) VALUES ('$username', '$hashed_password', '$full_name','user')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Berhasil daftar!');</script>";
        echo "<script>window.location.href = '../index.php';</script>";
    } else {
        echo "<script>alert('Gagal daftar!');</script>";
        echo "<script>window.location.href = '../register.php';</script>";
    }
}

mysqli_close($conn);
?>
