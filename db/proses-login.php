<?php 

require_once 'koneksi.php';

session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Get the hashed password from the database for the given username
    $stmt = $conn->prepare("SELECT id, username, role, full_name, password FROM user WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();

        // Use password_verify() to check the password
        if (password_verify($password, $user_data['password'])) {
            $_SESSION['username'] = $user_data['username'];
            $_SESSION['role'] = $user_data['role'];
            $_SESSION['id'] = $user_data['id'];
            $_SESSION['full_name'] = $user_data['full_name'];
            
            header("Location: ../dashboard.php");
            exit();
        } else {
            echo "<script>alert('Username atau Password Salah');</script>";
            echo "<script>window.location.href = '../index.php?error=1';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Username tidak ditemukan');</script>";
        echo "<script>window.location.href = '../index.php?error=1';</script>";
        exit();
    }
}

?>
