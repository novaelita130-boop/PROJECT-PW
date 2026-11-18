<?php
session_start();
if (!isset($_SESSION["status_login"]) || ($_SESSION["role"] != "admin" && $_SESSION["role"] != "karyawan")) {
    header("Location: dashboard.php");
    exit();
}
include "../koneksi.php";

$id = $_GET['id'];
$q = mysqli_query($konek, "SELECT * FROM penggajian WHERE id_gaji = '$id'");
$data = mysqli_fetch_array($q);

// Ambil detail karyawan
$id_karyawan = $data['id_karyawan'];
$q_kar = mysqli_query($konek, "SELECT karyawan.*, jabatan.nama_jabatan FROM karyawan LEFT JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan WHERE karyawan.id_karyawan = '$id_karyawan'");
$d_kar = mysqli_fetch_array($q_kar);

$nik = isset($d_kar['nik']) ? $d_kar['nik'] : '-';
$alamat = isset($d_kar['alamat']) ? $d_kar['alamat'] : '-';
$jabatan = isset($d_kar['nama_jabatan']) ? $d_kar['nama_jabatan'] : '-';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - <?php echo $data['nama_karyawan']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #525659; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 40px 0; }
        .slip-container { background: white; width: 750px; margin: 0 auto; padding: 50px; border-radius: 6px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        .table td, .table th { padding: 12px 15px; }
        @media print {
            body { background: white; padding: 0; }
            .slip-container { box-shadow: none; width: 100%; padding: 20px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="slip-container">
        <div class="text-center border-bottom pb-4 mb-4">
            <h3 class="fw-bold m-0">PAYROLLKU</h3>
            <h5 class="text-secondary">SLIP GAJI KARYAWAN</h5>
            <small class="text-muted">Periode: <?php echo $data['bulan']; ?></small>
        </div>

        <div class="row mb-4">
            <div class="col-8">
                <table class="table table-borderless table-sm m-0">
                    <tr>
                        <td width="130" class="fw-semibold">NIK</td>
                        <td width="10">:</td>
                        <td><?php echo $nik; ?></td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Nama Karyawan</td>
                        <td>:</td>
                        <td class="fw-bold"><?php echo $data['nama_karyawan']; ?></td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Jabatan</td>
                        <td>:</td>
                        <td><?php echo $jabatan; ?></td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Alamat</td>
                        <td>:</td>
                        <td><?php echo $alamat; ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <h6 class="fw-bold mb-3">Rincian Penggajian</h6>
        <table class="table table-bordered align-middle">
            <tr>
                <td>Gaji Pokok</td>
                <td class="text-end">Rp <?php echo number_format($data['gaji_pokok'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td>Tunjangan Jabatan</td>
                <td class="text-end">Rp <?php echo number_format($data['tunjangan'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td>Potongan</td>
                <td class="text-end text-danger">- Rp <?php echo number_format($data['potongan'], 0, ',', '.'); ?></td>
            </tr>
            <tr class="table-primary fw-bold">
                <td>Total Gaji Diterima</td>
                <td class="text-end">Rp <?php echo number_format($data['total_gaji'], 0, ',', '.'); ?></td>
            </tr>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-5 pt-3">
            <div>
                <small class="text-muted">Tanggal Bayar: <?php echo $data['tanggal_bayar']; ?></small>
            </div>
            <div class="text-center">
                <p class="mb-5">Admin PAYROLLKU</p>
                <span class="fw-semibold">( ........................................ )</span>
            </div>
        </div>

        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary px-4"><i class="fa-solid fa-print me-2"></i> Cetak / Simpan Slip</button>
            <a href="penggajian.php" class="btn btn-secondary px-4 ms-2">Kembali</a>
        </div>
    </div>

</body>
</html>