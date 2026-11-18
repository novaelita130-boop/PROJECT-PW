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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Gaji - PAYROLLKU</title>
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
        .card-box { background: white; border-radius: 14px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04); border: none; }
        .table th { font-size: 14px; font-weight: 600; background-color: #f8fafc; }
        .table td { font-size: 14px; padding: 14px 12px; vertical-align: middle; }
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
            <li><a href="gaji.php"><i class="fa-solid fa-wallet"></i> Gaji Saya</a></li>
            <li><a href="riwayat_gaji.php" class="active"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Gaji</a></li>
            <li class="mt-5"><a href="../logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <div>
                <h4 class="fw-bold text-dark m-0">Riwayat Gaji</h4>
                <span class="text-muted">Beranda / Riwayat Gaji</span>
            </div>
            <div>
                <span class="fw-semibold text-dark fs-5"><i class="fa-solid fa-user-circle me-2"></i> Halo, <?php echo $_SESSION['username']; ?></span>
            </div>
        </div>

        <div class="card-box">
            <h4 class="fw-bold text-dark mb-3">Histori Slip Gaji Anda</h4>
            <div class="table-responsive">
                <table class="table table-hover align-middle mt-2">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Periode</th>
                            <th>Total Gaji</th>
                            <th>Status Pembayaran</th>
                            <th>Tanggal Bayar</th>
                            <th>Slip</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($konek, "SELECT * FROM penggajian WHERE id_karyawan = '$id_karyawan' ORDER BY id_gaji DESC");
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_array($query)) {
                                $status = isset($row['status']) ? $row['status'] : 'Belum Dibayar';
                               $badgeClass = ($status == 'Dibayar') ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger';
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td class="fw-semibold"><?php echo $row['bulan']; ?></td>
                            <td class="fw-bold text-primary">Rp <?php echo number_format($row['total_gaji'], 0, ',', '.'); ?></td>
                            <td>
                                <span class="badge <?php echo $badgeClass; ?> px-3 py-2">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                            <td><?php echo isset($row['tanggal_bayar']) && $row['tanggal_bayar'] != '' ? $row['tanggal_bayar'] : '-'; ?></td>
                            <td>
                               <a href="../admin/slip_gaji.php?id=<?php echo $row['id_gaji']; ?>" target="_blank" class="btn btn-outline-primary btn-sm px-3 py-1">
    <i class="fa-solid fa-file-lines me-1"></i> Slip
</a>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-center text-muted py-4">Belum ada riwayat gaji tercatat.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>