<?php
session_start();
if (!isset($_SESSION["status_login"]) || $_SESSION["role"] != "karyawan") {
    header("Location: ../index.php");
    exit();
}
include "../koneksi.php";

$username_login = $_SESSION['username'];
$q_kar = mysqli_query($konek, "SELECT karyawan.*, jabatan.nama_jabatan FROM karyawan LEFT JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan WHERE karyawan.nama_karyawan LIKE '%$username_login%' OR karyawan.email LIKE '%$username_login%'");
$d_kar = mysqli_fetch_array($q_kar);

$id_karyawan = $d_kar ? $d_kar['id_karyawan'] : 0;
$jabatan_kar = isset($d_kar['nama_jabatan']) ? $d_kar['nama_jabatan'] : '-';

// Ambil gaji terbaru bulan ini
$q_gaji = mysqli_query($konek, "SELECT * FROM penggajian WHERE id_karyawan = '$id_karyawan' ORDER BY id_gaji DESC LIMIT 1");
$d_gaji = mysqli_fetch_array($q_gaji);
$total_gaji_terbaru = $d_gaji ? $d_gaji['total_gaji'] : 0;
$periode_terbaru = $d_gaji ? $d_gaji['bulan'] : 'Belum ada data';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Karyawan - PAYROLLKU</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f1f5f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { width: 280px; height: 100vh; position: fixed; top: 0; left: 0; background-color: #1e3a8a; color: white; display: flex; flex-direction: column; z-index: 100; }
        .sidebar-brand { padding: 30px 20px; text-align: center; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .sidebar-menu { list-style: none; padding: 25px 15px; margin: 0; flex-grow: 1; }
        .sidebar-menu li { margin-bottom: 12px; }
        .sidebar-menu a { color: rgba(255, 255, 255, 0.8); text-decoration: none; display: flex; align-items: center; padding: 14px 18px; border-radius: 10px; font-weight: 500; transition: all 0.2s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { color: white; background-color: #2563eb; }
        .sidebar-menu a i { margin-right: 15px; font-size: 20px; }
        .main-content { margin-left: 280px; padding: 35px; }
        .top-navbar { background: white; padding: 20px 30px; border-radius: 14px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .welcome-card { background: white; border-radius: 14px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04); margin-bottom: 30px; border: none; position: relative; overflow: hidden; }
        .info-card { background: white; border-radius: 14px; padding: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04); border: none; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fa-solid fa-users fa-3x mb-2 text-white"></i>
            <h3 class="fw-bold m-0">PAYROLLKU</h3>
            <small class="text-white opacity-75">Portal Karyawan</small>
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php" class="active"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li><a href="profil.php"><i class="fa-solid fa-user"></i> Profil Saya</a></li>
            <li><a href="gaji.php"><i class="fa-solid fa-wallet"></i> Gaji Saya</a></li>
            <li><a href="riwayat_gaji.php"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Gaji</a></li>
            <li class="mt-5"><a href="../logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <div>
                <h4 class="fw-bold text-dark m-0">Dashboard Karyawan</h4>
                <span class="text-muted">Beranda / Dashboard</span>
            </div>
            <div>
                <span class="fw-semibold text-dark fs-5"><i class="fa-solid fa-user-circle me-2"></i> Halo, <?php echo $_SESSION['username']; ?></span>
            </div>
        </div>

        <div class="welcome-card">
            <h3 class="fw-bold text-dark mb-2">Selamat datang, <?php echo isset($d_kar['nama_karyawan']) ? $d_kar['nama_karyawan'] : $_SESSION['username']; ?>!</h3>
            <p class="text-muted m-0">Nikmati pengalaman terbaik dalam melihat informasi gaji dan profil Anda.</p>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="info-card d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-4 text-primary me-3 fs-3">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <div>
                        <span class="text-muted small">Jabatan Anda</span>
                        <h5 class="fw-bold text-dark m-0"><?php echo $jabatan_kar; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="info-card d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-4 text-warning me-3 fs-3">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <span class="text-muted small">Gaji Bulan Ini (<?php echo $periode_terbaru; ?>)</span>
                        <h5 class="fw-bold text-primary m-0">Rp <?php echo number_format($total_gaji_terbaru, 0, ',', '.'); ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>