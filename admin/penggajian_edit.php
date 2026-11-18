<?php
session_start();
if (!isset($_SESSION["status_login"]) || $_SESSION["role"] != "admin") {
    header("Location: ../index.php");
    exit();
}
include "../koneksi.php";

$id = $_GET['id'];

$query_data = mysqli_query($konek, "SELECT penggajian.*, karyawan.nama_karyawan FROM penggajian LEFT JOIN karyawan ON penggajian.id_karyawan = karyawan.id_karyawan WHERE penggajian.id_gaji = '$id'");
$data = mysqli_fetch_array($query_data);

if (isset($_POST['update'])) {
    $potongan   = $_POST['potongan'];
    $total_gaji = $_POST['total_gaji'];
    $status     = $_POST['status'];

    $update = mysqli_query($konek, "UPDATE penggajian SET 
                potongan = '$potongan', 
                total_gaji = '$total_gaji', 
                status = '$status' 
              WHERE id_gaji = '$id'");

    if ($update) {
        echo "<script>alert('Data penggajian berhasil diubah!'); window.location='penggajian.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah data!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Penggajian - PAYROLLKU</title>
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
        <div class="card-header-top d-flex justify-content-between align-items-center">
            <div>
                <h4>Edit Penggajian</h4>
                <small>Beranda / Penggajian / Edit</small>
            </div>
            <a href="penggajian.php" class="btn btn-secondary btn-sm px-3" style="font-size: 12px; border-radius: 8px;"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
        </div>

        <div class="card card-custom p-4" style="max-width: 650px;">
            <form action="" method="POST">
                <!-- Karyawan (Dikunci / Readonly text) -->
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Karyawan</label>
                    <input type="text" class="form-control form-control-sm bg-light" value="<?php echo $data['nama_karyawan']; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Bulan / Periode</label>
                    <input type="text" class="form-control form-control-sm bg-light" value="<?php echo $data['bulan']; ?>" readonly>
                </div>

               
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Gaji Pokok</label>
                    <input type="number" id="gaji_pokok" class="form-control form-control-sm bg-light" value="<?php echo $data['gaji_pokok']; ?>" readonly>
                </div>

                
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Tunjangan</label>
                    <input type="number" id="tunjangan" class="form-control form-control-sm bg-light" value="<?php echo $data['tunjangan']; ?>" readonly>
                </div>

                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-primary" style="font-size: 13px;">Potongan</label>
                    <input type="number" name="potongan" id="potongan" class="form-control form-control-sm" value="<?php echo $data['potongan']; ?>" required autocomplete="off">
                </div>

                
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Total Gaji</label>
                    <input type="number" name="total_gaji" id="total_gaji" class="form-control form-control-sm bg-light fw-bold text-primary" value="<?php echo $data['total_gaji']; ?>" readonly required>
                </div>

                
                <div class="mb-4">
                    <label class="form-label fw-semibold text-primary" style="font-size: 13px;">Status Pembayaran</label>
                    <select name="status" class="form-select form-select-sm" required>
                        <option value="Dibayar" <?php if($data['status'] == 'Dibayar') echo 'selected'; ?>>Dibayar</option>
                        <option value="Belum Dibayar" <?php if($data['status'] == 'Belum Dibayar') echo 'selected'; ?>>Belum Dibayar</option>
                    </select>
                </div>

                <button type="submit" name="update" class="btn btn-primary-gradient w-100 py-2">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    
    <script>
        const gajiPokok = document.getElementById('gaji_pokok');
        const tunjangan = document.getElementById('tunjangan');
        const potongan = document.getElementById('potongan');
        const totalGaji = document.getElementById('total_gaji');

        function hitungTotal() {
            let gp = parseFloat(gajiPokok.value) || 0;
            let tj = parseFloat(tunjangan.value) || 0;
            let pt = parseFloat(potongan.value) || 0;
            
            totalGaji.value = (gp + tj) - pt;
        }

        potongan.addEventListener('input', hitungTotal);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>