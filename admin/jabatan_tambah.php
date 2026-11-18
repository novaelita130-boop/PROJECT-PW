<?php
session_start();
if (!isset($_SESSION["status_login"]) || $_SESSION["role"] != "admin") {
    header("Location: ../index.php");
    exit();
}
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $nama_jabatan = $_POST['nama_jabatan'];
    $gaji_pokok   = $_POST['gaji_pokok'];
    $tunjangan    = $_POST['tunjangan'];

    $query = mysqli_query($konek, "INSERT INTO jabatan (nama_jabatan, gaji_pokok, tunjangan) VALUES ('$nama_jabatan', '$gaji_pokok', '$tunjangan')");
    if ($query) {
        echo "<script>alert('Data jabatan berhasil ditambahkan!'); window.location='jabatan.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan jabatan!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Jabatan - PAYROLLKU</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fa-solid fa-users-gear fa-2x text-white mb-1"></i>
            <h5>PAYROLLKU</h5>
            <small>Sistem Penggajian Karyawan</small>
        </div>
        <a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="karyawan.php"><i class="fa-solid fa-users"></i> Data Karyawan</a>
        <a href="jabatan.php" class="active"><i class="fa-solid fa-briefcase"></i> Jabatan</a>
        <a href="penggajian.php"><i class="fa-solid fa-file-invoice-dollar"></i> Penggajian</a>
        <hr class="text-light opacity-25 my-3">
        <a href="tambah_akun.php"><i class="fa-solid fa-user-plus"></i> Kelola Akun</a>
        <a href="../logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
   
    </div>

    <div class="main-content">
        <div class="card-header-top">
            <div>
                <h4>Tambah Jabatan</h4>
                <small>Beranda / Jabatan / Tambah</small>
            </div>
            <a href="jabatan.php" class="btn btn-secondary btn-sm px-3" style="font-size: 12px; border-radius: 8px;"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
        </div>

        <div class="card card-custom p-4" style="max-width: 650px;">
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Nama Jabatan</label>
                    <input type="text" name="nama_jabatan" class="form-control form-control-sm" placeholder="Contoh: Manager / Staff" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Gaji Pokok (Rp)</label>
                    <input type="number" name="gaji_pokok" class="form-control form-control-sm" placeholder="Contoh: 5000000" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Tunjangan (Rp)</label>
                    <input type="number" name="tunjangan" class="form-control form-control-sm" placeholder="Contoh: 1000000" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary-gradient w-100 py-2">Simpan Data Jabatan</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>