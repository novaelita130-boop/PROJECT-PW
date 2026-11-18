<?php
session_start();
if (!isset($_SESSION["status_login"]) || $_SESSION["role"] != "admin") {
    header("Location: ../index.php");
    exit();
}
include "../koneksi.php";

//ini buat ngitung total karyawan yang input sama si admin
$q_karyawan = mysqli_query($konek, "SELECT COUNT(*) AS total FROM karyawan");
$d_karyawan = mysqli_fetch_array($q_karyawan);
$jml_karyawan = $d_karyawan['total'] ? $d_karyawan['total'] : 0;

// yg ini buat ngitung total jabatan
$q_jabatan = mysqli_query($konek, "SELECT COUNT(*) AS total FROM jabatan");
$d_jabatan = mysqli_fetch_array($q_jabatan);
$jml_jabatan = $d_jabatan['total'] ? $d_jabatan['total'] : 0;

// C. buat tampilan di total gaji, jadi biar bisa neglihat akumulasi gaji gaji karyawan
$q_akumulasi = mysqli_query($konek, "SELECT SUM(total_gaji) AS total FROM penggajian");
$d_akumulasi = mysqli_fetch_array($q_akumulasi);
$total_penggajian = $d_akumulasi['total'] ? $d_akumulasi['total'] : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - PAYROLLKU</title>
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
        <a href="dashboard.php" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="karyawan.php"><i class="fa-solid fa-users"></i> Data Karyawan</a>
        <a href="jabatan.php"><i class="fa-solid fa-briefcase"></i> Jabatan</a>
        <a href="penggajian.php"><i class="fa-solid fa-file-invoice-dollar"></i> Penggajian</a>
        <hr class="text-light opacity-25 my-3">
        <a href="tambah_akun.php"><i class="fa-solid fa-user-plus"></i> Kelola Akun</a>
        <a href="../logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
    //ini udh masuk k bgian dashboard
    <div class="main-content">
        <div class="card-header-top d-flex justify-content-between align-items-center">
            <div>
                <h4>Dashboard Utama</h4>
                <small>Beranda / Dashboard</small>
            </div>
            <div class="fw-semibold text-secondary" style="font-size: 13px;">
                <i class="fa-solid fa-circle-user me-1 text-primary"></i> Halo, <?php echo $_SESSION['username']; ?>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card card-custom p-3" style="border-left: 4px solid #2563eb;">
                    <h6 class="text-muted" style="font-size: 12px; font-weight: 600;">Total Karyawan</h6>
                    <h3 class="fw-bold m-0" style="font-size: 22px; color: #1e293b;"><?php echo $jml_karyawan; ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-3" style="border-left: 4px solid #10b981;">
                    <h6 class="text-muted" style="font-size: 12px; font-weight: 600;">Total Jabatan</h6>
                    <h3 class="fw-bold m-0" style="font-size: 22px; color: #1e293b;"><?php echo $jml_jabatan; ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-3" style="border-left: 4px solid #f59e0b;">
                    <h6 class="text-muted" style="font-size: 12px; font-weight: 600;">Akumulasi Penggajian</h6>
                    <h3 class="fw-bold m-0" style="font-size: 22px; color: #1e293b;">Rp <?php echo number_format($total_penggajian, 0, ',', '.'); ?></h3>
                </div>
            </div>
        </div>

        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Riwayat Penggajian Terbaru</h6>
                <a href="penggajian.php" class="btn btn-outline-primary btn-sm px-3 py-1 fw-semibold" style="font-size: 12px; border-radius: 20px;">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle" style="font-size: 14px;">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">No</th>
                            <th class="py-3">Nama Karyawan</th>
                            <th class="py-3">Bulan / Periode</th>
                            <th class="py-3">Total Gaji</th>
                            <th class="py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                     $q_riwayat = mysqli_query($konek, "SELECT penggajian.*, karyawan.nama_karyawan FROM penggajian LEFT JOIN karyawan ON penggajian.id_karyawan = karyawan.id_karyawan LIMIT 5");
                        
                        if ($q_riwayat && mysqli_num_rows($q_riwayat) > 0) {
                            while ($r = mysqli_fetch_array($q_riwayat)) {
                                $badge_class = ($r['status'] == 'Dibayar') ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-warning';
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td class="fw-semibold"><?php echo isset($r['nama_karyawan']) && !empty($r['nama_karyawan']) ? $r['nama_karyawan'] : 'Karyawan Dihapus'; ?></td>
                            <td><?php echo $r['bulan']; ?></td>
                            <td class="fw-bold text-primary">Rp <?php echo number_format($r['total_gaji'], 0, ',', '.'); ?></td>
                            <td>
                                <span class="badge <?php echo $badge_class; ?> px-3 py-1 rounded-pill" style="font-size: 11px;">
                                    <?php echo $r['status']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat penggajian.</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>