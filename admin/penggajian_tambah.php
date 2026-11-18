<?php
session_start();
if (!isset($_SESSION["status_login"]) || $_SESSION["role"] != "admin") {
    header("Location: ../index.php");
    exit();
}
include "../koneksi.php";

if (isset($_POST['hitung_simpan'])) {
    $id_karyawan   = $_POST['id_karyawan'];
    $bulan         = $_POST['bulan'];
    $potongan      = !empty($_POST['potongan']) ? $_POST['potongan'] : 0;
    $status        = $_POST['status'];
    $tanggal_bayar = !empty($_POST['tanggal_bayar']) ? $_POST['tanggal_bayar'] : '-';
    $tanggal_input = date('Y-m-d');

    //ngambil data karyawan sama id jabatan
    $q_kar = mysqli_query($konek, "SELECT * FROM karyawan WHERE id_karyawan = '$id_karyawan'");
    $d_kar = mysqli_fetch_array($q_kar);
    
    $nama_karyawan = $d_kar ? $d_kar['nama_karyawan'] : '';
    $id_jabatan    = $d_kar ? $d_kar['id_jabatan'] : ''; //nyimpen id jabatan
    
    // ngeliatin gaji pokok tunjangan sesuai yg ada di data jabatan
    $q_jab = mysqli_query($konek, "SELECT * FROM jabatan WHERE id_jabatan = '$id_jabatan'");
    $d_jab = mysqli_fetch_array($q_jab);
    
    $gaji_pokok    = ($d_jab && isset($d_jab['gaji_pokok'])) ? $d_jab['gaji_pokok'] : 0;
    $tunjangan     = ($d_jab && isset($d_jab['tunjangan'])) ? $d_jab['tunjangan'] : 0;
    
    // buat total gaji 
    $total_gaji    = ($gaji_pokok + $tunjangan) - $potongan;


    $query = mysqli_query($konek, "INSERT INTO penggajian (id_karyawan, nama_karyawan, bulan, gaji_pokok, tunjangan, potongan, total_gaji, status, tanggal_bayar, tanggal_input) VALUES ('$id_karyawan', '$nama_karyawan', '$bulan', '$gaji_pokok', '$tunjangan', '$potongan', '$total_gaji', '$status', '$tanggal_bayar', '$tanggal_input')");

    if ($query) {
        echo "<script>alert('Data penggajian berhasil disimpan!'); window.location='penggajian.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan penggajian!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Penggajian - PAYROLLKU</title>
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
        <a href="jabatan.php"><i class="fa-solid fa-briefcase"></i> Jabatan</a>
        <a href="penggajian.php" class="active"><i class="fa-solid fa-file-invoice-dollar"></i> Penggajian</a>
        <hr class="text-light opacity-25 my-3">
        <a href="tambah_akun.php"><i class="fa-solid fa-user-plus"></i> Kelola Akun</a>
        <a href="../logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="card-header-top">
            <div>
                <h4>Tambah Penggajian</h4>
                <small>Beranda / Penggajian / Tambah</small>
            </div>
            <a href="penggajian.php" class="btn btn-secondary btn-sm px-3" style="font-size: 12px; border-radius: 8px;"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
        </div>

        <div class="card card-custom p-4" style="max-width: 650px;">
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Pilih Karyawan</label>
                    <select name="id_karyawan" class="form-select form-select-sm" required>
                        <option value="">-- Pilih Karyawan --</option>
                        <?php
$query_karyawan = mysqli_query($konek, "SELECT karyawan.*, jabatan.nama_jabatan FROM karyawan LEFT JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan");
while ($k = mysqli_fetch_array($query_karyawan)) {
    $nama_jab = isset($k['nama_jabatan']) ? $k['nama_jabatan'] : '-';
   echo "<option value='".$k['id_karyawan']."'>".$k['nama_karyawan']." (".$nama_jab.")</option>";
}
?>
                        
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Bulan / Periode</label>
                    <input type="text" name="bulan" class="form-control form-control-sm" placeholder="Contoh: November 2026" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Potongan (Rp)</label>
                    <input type="number" name="potongan" class="form-control form-control-sm" value="0" placeholder="Masukkan besar potongan jika ada">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Status Pembayaran</label>
                    <select name="status" class="form-select form-select-sm" required>
                        <option value="Belum Dibayar">Belum Dibayar</option>
                        <option value="Dibayar">Dibayar</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Tanggal Bayar</label>
                    <input type="date" name="tanggal_bayar" class="form-control form-control-sm">
                </div>
                <button type="submit" name="hitung_simpan" class="btn btn-primary-gradient w-100 py-2">Hitung & Simpan Penggajian</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>