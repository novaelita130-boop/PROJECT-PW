<?php
session_start();
if (!isset($_SESSION["status_login"]) || $_SESSION["role"] != "karyawan") {
    header("Location: ../index.php");
    exit();
}
include "../koneksi.php";

$username_login = $_SESSION['username'];

$q_kar = mysqli_query($konek, "SELECT * FROM karyawan WHERE nama_karyawan LIKE '%$username_login%' OR email LIKE '%$username_login%'");
$d_kar = mysqli_fetch_array($q_kar);
$id_karyawan = $d_kar ? $d_kar['id_karyawan'] : 0;

// query ngambil gaji terbaru
$q_gaji = mysqli_query($konek, "SELECT * FROM penggajian WHERE id_karyawan = '$id_karyawan' ORDER BY id_gaji DESC LIMIT 1");
$d_gaji = mysqli_fetch_array($q_gaji);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gaji Saya - PAYROLLKU</title>
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
        .card-box { background: white; border-radius: 14px; padding: 35px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04); border: none; max-width: 800px; }
        .header-gaji { background: #f8fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #e2e8f0; }
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
            <li><a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li><a href="profil.php"><i class="fa-solid fa-user"></i> Profil Saya</a></li>
            <li><a href="gaji.php" class="active"><i class="fa-solid fa-wallet"></i> Gaji Saya</a></li>
            <li><a href="riwayat_gaji.php"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Gaji</a></li>
            <li class="mt-5"><a href="../logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <div>
                <h4 class="fw-bold text-dark m-0">Gaji Saya</h4>
                <span class="text-muted">Beranda / Gaji Saya</span>
            </div>
            <div>
                <span class="fw-semibold text-dark fs-5"><i class="fa-solid fa-user-circle me-2"></i> Halo, <?php echo $_SESSION['username']; ?></span>
            </div>
        </div>

        <div class="card-box">
            <div class="header-gaji d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small d-block">Gaji Bulan Ini</span>
                    <h3 class="fw-bold text-primary m-0">Rp <?php echo $d_gaji ? number_format($d_gaji['total_gaji'], 0, ',', '.') : '0'; ?></h3>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 fs-6">
                        <i class="fa-solid fa-calendar-days me-1"></i> <?php echo $d_gaji ? $d_gaji['bulan'] : '-'; ?>
                    </span>
                </div>
            </div>

            <h5 class="fw-bold text-dark mb-3">Rincian Gaji</h5>
            <table class="table table-bordered align-middle">
                <tr>
                    <td class="fw-semibold text-secondary">Gaji Pokok</td>
                    <td class="text-end fw-semibold">Rp <?php echo $d_gaji ? number_format($d_gaji['gaji_pokok'], 0, ',', '.') : '0'; ?></td>
                </tr>
                <tr>
                    <td class="fw-semibold text-secondary">Tunjangan Jabatan</td>
                    <td class="text-end fw-semibold">Rp <?php echo $d_gaji ? number_format($d_gaji['tunjangan'], 0, ',', '.') : '0'; ?></td>
                </tr>
                <tr>
                    <td class="fw-semibold text-secondary">Potongan</td>
                    <td class="text-end fw-semibold text-danger">Rp <?php echo $d_gaji ? number_format($d_gaji['potongan'], 0, ',', '.') : '0'; ?></td>
                </tr>
                <tr class="table-primary fw-bold">
                    <td>Total Gaji Diterima</td>
                    <td class="text-end text-primary">Rp <?php echo $d_gaji ? number_format($d_gaji['total_gaji'], 0, ',', '.') : '0'; ?></td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>