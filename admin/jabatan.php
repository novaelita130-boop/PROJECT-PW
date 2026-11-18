<?php
session_start();
if (!isset($_SESSION["status_login"]) || $_SESSION["role"] != "admin") {
    header("Location: ../index.php");
    exit();
}
include "../koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Jabatan - PAYROLLKU</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    //bagian sidebar
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
        <a href="tambah_akun.php"><i class="fa-solid fa-user-plus"></i> Kelola Akun</a>
        <hr class="text-light opacity-25 my-3">
        
        <a href="../logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="card-header-top">
            <div>
                <h4>Data Jabatan</h4>
                <small>Beranda / Jabatan</small>
            </div>
            <div class="fw-semibold text-secondary" style="font-size: 13px;">
                <i class="fa-solid fa-circle-user me-1 text-primary"></i> Halo, <?php echo $_SESSION['username']; ?>
            </div>
        </div>
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-briefcase text-primary me-2"></i> Daftar Jabatan & Gaji</h6>
                <a href="jabatan_tambah.php" class="btn btn-primary-gradient"><i class="fa-solid fa-plus me-1"></i> Tambah Jabatan</a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Jabatan</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($konek, "SELECT * FROM jabatan");
                        if ($query && mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_array($query)) {
                                $gaji_pokok = isset($row['gaji_pokok']) ? $row['gaji_pokok'] : 0;
                                $tunjangan = isset($row['tunjangan']) ? $row['tunjangan'] : 0;
                                
                                echo '<tr>
                                    <td>'.$no++.'</td>
                                    <td class="fw-bold">'.$row['nama_jabatan'].'</td>
                                    <td>Rp '.number_format($gaji_pokok, 0, ',', '.').'</td>
                                    <td>Rp '.number_format($tunjangan, 0, ',', '.').'</td>
                                    <td>
                                        <a href="jabatan_edit.php?id='.$row['id_jabatan'].'" class="btn btn-warning btn-sm text-dark px-2 py-1" style="font-size: 11px;"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="jabatan_hapus.php?id='.$row['id_jabatan'].'" class="btn btn-danger btn-sm px-2 py-1" style="font-size: 11px;" onclick="return confirm(\'Yakin ingin menghapus?\')"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>';
                            }
                        } else {
                            echo '<tr><td colspan="5" class="text-center text-muted py-3">Belum ada data jabatan.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>