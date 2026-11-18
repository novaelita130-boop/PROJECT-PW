<?php
session_start();
if (!isset($_SESSION["status_login"]) || $_SESSION["role"] != "admin") {
    header("Location: ../index.php");
    exit();
}
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $nik           = $_POST['nik'];
    $nama_karyawan = $_POST['nama_karyawan'];
    $id_jabatan    = $_POST['id_jabatan']; 
    $alamat        = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    
    $query = mysqli_query($konek, "INSERT INTO karyawan (nik, nama_karyawan, id_jabatan, alamat, no_hp) VALUES ('$nik', '$nama_karyawan', '$id_jabatan', '$alamat', '$no_hp')");
    if ($query) {
        echo "<script>alert('Data karyawan berhasil ditambahkan!'); window.location='karyawan.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Karyawan - PAYROLLKU</title>
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
        <a href="karyawan.php" class="active"><i class="fa-solid fa-users"></i> Data Karyawan</a>
        <a href="jabatan.php"><i class="fa-solid fa-briefcase"></i> Jabatan</a>
        <a href="penggajian.php"><i class="fa-solid fa-file-invoice-dollar"></i> Penggajian</a>
        <hr class="text-light opacity-25 my-3">
        <a href="tambah_akun.php"><i class="fa-solid fa-user-plus"></i> Kelola Akun</a>
        <a href="../logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="card-header-top">
            <div>
                <h4>Tambah Karyawan</h4>
                <small>Beranda / Data Karyawan / Tambah</small>
            </div>
            <a href="karyawan.php" class="btn btn-secondary btn-sm px-3" style="font-size: 12px; border-radius: 8px;"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
        </div>

        <div class="card card-custom p-4" style="max-width: 650px;">
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">NIK</label>
                    <input type="text" name="nik" class="form-control form-control-sm" placeholder="Masukkan NIK" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Nama Karyawan</label>
                    <input type="text" name="nama_karyawan" class="form-control form-control-sm" placeholder="Masukkan Nama Lengkap" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Jabatan</label>
                    <select name="id_jabatan" class="form-select form-select-sm" required>
                        <option value="">-- Pilih Jabatan --</option>
                        <?php
                        $q_jab = mysqli_query($konek, "SELECT * FROM jabatan");
                        while ($j = mysqli_fetch_array($q_jab)) {
                            echo "<option value='".$j['id_jabatan']."'>".$j['nama_jabatan']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Alamat</label>
                    <textarea name="alamat" class="form-control form-control-sm" rows="3" placeholder="Masukkan Alamat"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">No. Telepon</label>
                    <input type="text" name="no_hp" class="form-control form-control-sm" placeholder="No. Telepon" required autocomplete="off">
                </div>
                <button type="submit" name="simpan" class="btn btn-primary-gradient w-100 py-2">Simpan Data Karyawan</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>