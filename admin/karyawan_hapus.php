<?php
session_start();
if (!isset($_SESSION["status_login"]) || $_SESSION["role"] != "admin") {
    header("Location: ../index.php");
    exit();
}
include "../koneksi.php";

$id = $_GET['id'];
$query = mysqli_query($konek, "DELETE FROM karyawan WHERE id_karyawan = '$id'");

if ($query) {
    echo "<script>alert('Data karyawan berhasil dihapus!'); window.location='karyawan.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data karyawan!'); window.location='karyawan.php';</script>";
}
?>