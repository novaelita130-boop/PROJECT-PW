<?php
session_start();
if (!isset($_SESSION["status_login"]) || $_SESSION["role"] != "admin") {
    header("Location: ../index.php");
    exit();
}
include "../koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($konek, "DELETE FROM jabatan WHERE id_jabatan = '$id'");

if ($query) {
    echo "<script>alert('Data jabatan berhasil dihapus!'); window.location='jabatan.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data jabatan!'); window.location='jabatan.php';</script>";
}
?>