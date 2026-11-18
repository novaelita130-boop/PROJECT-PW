<?php
session_start();
if (!isset($_SESSION["status_login"]) || $_SESSION["role"] != "admin") {
    header("Location: ../index.php");
    exit();
}
include "../koneksi.php";

$id = $_GET['id'];

// sql buat ngambil data jabatan dari nomor id
$data = mysqli_query($konek, "SELECT * FROM jabatan WHERE id_jabatan = '$id'");
$row = mysqli_fetch_array($data);

if (isset($_POST['update'])) {
    $nama_jabatan = $_POST['nama_jabatan'];
    $gaji_pokok   = $_POST['gaji_pokok'];
    $tunjangan    = $_POST['tunjangan'];

    $update = mysqli_query($konek, "UPDATE jabatan SET nama_jabatan = '$nama_jabatan', gaji_pokok = '$gaji_pokok', tunjangan = '$tunjangan' WHERE id_jabatan = '$id'");
    
    if ($update) {
        echo "<script>alert('Data jabatan berhasil diperbarui!'); window.location='jabatan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui jabatan!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Jabatan - PAYROLLKU</title>
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
                <h4>Edit Jabatan</h4>
                <small>Beranda / Jabatan / Edit</small>
            </div>
            <a href="jabatan.php" class="btn btn-secondary btn-sm px-3" style="font-size: 12px; border-radius: 8px;"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
        </div>

        <div class="card card-custom p-4" style="max-width: 650px;">
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Nama Jabatan</label>
                    <input type="text" name="nama_jabatan" class="form-control form-control-sm" value="<?php echo $row['nama_jabatan']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Gaji Pokok (Rp)</label>
                    <input type="number" name="gaji_pokok" class="form-control form-control-sm" value="<?php echo $row['gaji_pokok']; ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Tunjangan (Rp)</label>
                    <input type="number" name="tunjangan" class="form-control form-control-sm" value="<?php echo $row['tunjangan']; ?>" required>
                </div>
                <button type="submit" name="update" class="btn btn-primary-gradient w-100 py-2">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>