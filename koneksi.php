<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "penggajian_karyawan"; // Pastikan sama dengan nama database di phpMyAdmin

//buat koneksi
$konek = mysqli_connect($hostname, $username, $password, $database);

//buat ngecek koneksi
if (!$konek) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>