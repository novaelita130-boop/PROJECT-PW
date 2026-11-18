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
    <title>Data Penggajian - PAYROLLKU</title>
    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts Poppins -->
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
                <h4>Riwayat Penggajian</h4>
                <small>Beranda / Penggajian</small>
            </div>
            <div class="fw-semibold text-secondary" style="font-size: 13px;">
                <i class="fa-solid fa-circle-user me-1 text-primary"></i> Halo, <?php echo $_SESSION['username']; ?>
            </div>
        </div>

        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-file-invoice-dollar text-primary me-2"></i> Daftar Transaksi Gaji</h6>
                    <small class="text-muted" style="font-size: 11.5px;">Daftar transaksi gaji seluruh karyawan</small>
                </div>
                <a href="penggajian_tambah.php" class="btn btn-primary-gradient"><i class="fa-solid fa-plus me-1"></i> Tambah Penggajian</a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Karyawan</th>
                            <th>Periode</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan</th>
                            <th>Potongan</th>
                            <th>Total Gaji</th>
                            <th>Status</th>
                            <th>Slip</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($konek, "SELECT * FROM penggajian");
                        if ($query && mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_array($query)) {
                                $gaji_pokok = isset($row['gaji_pokok']) ? $row['gaji_pokok'] : 0;
                                $tunjangan  = isset($row['tunjangan']) ? $row['tunjangan'] : 0;
                                $potongan   = isset($row['potongan']) ? $row['potongan'] : 0;
                                $total_gaji = isset($row['total_gaji']) ? $row['total_gaji'] : 0;
                                
                                $status     = isset($row['status']) ? $row['status'] : 'Belum Dibayar';
                                $badge_bg   = ($status == 'Dibayar') ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger';

                                echo '<tr>
                                    <td>'.$no++.'</td>
                                    <td class="fw-bold">'.$row['nama_karyawan'].'</td>
                                    <td>'.$row['bulan'].'</td>
                                    <td>Rp '.number_format($gaji_pokok, 0, ',', '.').'</td>
                                    <td>Rp '.number_format($tunjangan, 0, ',', '.').'</td>
                                    <td class="text-danger">- Rp '.number_format($potongan, 0, ',', '.').'</td>
                                    <td class="fw-bold text-primary">Rp '.number_format($total_gaji, 0, ',', '.').'</td>
                                    <td><span class="badge '.$badge_bg.' px-3 py-1 rounded-pill" style="font-size: 11px;">'.$status.'</span></td>
                                    <td>
                                        <a href="slip_gaji.php?id='.$row['id_gaji'].'" class="btn btn-outline-primary btn-sm px-2 py-1" style="font-size: 11px; border-radius: 20px;"><i class="fa-solid fa-print me-1"></i> Slip</a>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                        <a href="penggajian_edit.php?id='.$row['id_gaji'].'"class="btn btn-warning btn-sm px-2 py-1 me-1 text-dark" style="font-size: 11px;" title="Edit">
        <i class="fa-solid fa-pen-to-square"></i>
                                        <a href="penggajian_hapus.php?id='.$row['id_gaji'].'" class="btn btn-danger btn-sm px-2 py-1" style="font-size: 11px;" onclick="return confirm(\'Yakin ingin menghapus data ini?\')"><i class="fa-solid fa-trash"></i></a>
                                        </div>                                   
                                    </td>
                                </tr>';
                            }
                        } else {
                            echo '<tr><td colspan="10" class="text-center text-muted py-3">Belum ada riwayat penggajian.</td></tr>';
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