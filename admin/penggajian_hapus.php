<?php
session_start();
if (!isset($_SESSION["status_login"]) || $_SESSION["role"] != "admin") {
    header("Location: ../index.php");
    exit();
}
include "../koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // ini yg buat query gaji ya
    $query = mysqli_query($konek, "DELETE FROM penggajian WHERE id_gaji = '$id'");
    
    if ($query) {
        echo "<script>alert('Data penggajian berhasil dihapus!'); window.location='penggajian.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location='penggajian.php';</script>";
    }
} else {
    header("Location: penggajian.php");
}
?>