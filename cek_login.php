<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password_input = $_POST['password'];

// Mengambil data password dan role dari database berdasarkan username
$stmt = $konek->prepare("SELECT password, role FROM admin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($password_db, $role);
$stmt->fetch();
$stmt->close();

// Mengecek apakah username ditemukan dan passwordnya cocok (mendukung plain text maupun password_hash)
if ($password_db && ($password_input === $password_db || password_verify($password_input, $password_db))) {
    $_SESSION['status_login'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;

    // Arahkan sesuai role masing-masing
    if ($role == 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: karyawan/dashboard.php");
    }
    exit();
} else {
    // Jika gagal, kembalikan ke halaman login dengan pesan error
    header("Location: index.php?pesan=salah");
    exit();
}
?>