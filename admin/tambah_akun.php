<?php
session_start();
include "../koneksi.php";

// Cek login admin
if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$pesan = '';

//buat nambahin akun karyawan
if (isset($_POST['simpan'])) {
    $username = mysqli_real_escape_string($konek, $_POST['username']);
    $password = mysqli_real_escape_string($konek, $_POST['password']);
    $role = 'karyawan';

    $query = "INSERT INTO admin (username, password, role) VALUES ('$username', '$password', '$role')";
    if (mysqli_query($konek, $query)) {
        $pesan = "Akun berhasil ditambahkan!";
    }
}

// buat ngedit akun
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $username = mysqli_real_escape_string($konek, $_POST['username']);
    $password = mysqli_real_escape_string($konek, $_POST['password']);

    $query = "UPDATE admin SET username = '$username', password = '$password' WHERE id = '$id'";
    if (mysqli_query($konek, $query)) {
        $pesan = "Akun berhasil diubah!";
    }
}

// buat hapus akun karyawan
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($konek, "DELETE FROM admin WHERE id = '$id'");
    header("Location: tambah_akun.php");
    exit();
}

// ngambil data karyawan
$data_akun = mysqli_query($konek, "SELECT * FROM admin WHERE role = 'karyawan'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Akun - PAYROLLKU</title>
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
        <a href="penggajian.php"><i class="fa-solid fa-file-invoice-dollar"></i> Penggajian</a>
        <hr class="text-light opacity-25 my-3">
        <a href="tambah_akun.php" class="active"><i class="fa-solid fa-user-plus"></i> Kelola Akun</a>
        <a href="../logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="card-header-top d-flex justify-content-between align-items-center">
            <div>
                <h4>Kelola Akun Karyawan</h4>
                <small>Beranda / Kelola Akun</small>
            </div>
            <div class="fw-semibold text-secondary" style="font-size: 13px;">
                <i class="fa-solid fa-circle-user me-1 text-primary"></i> Halo, admin
            </div>
        </div>

        <?php if ($pesan != ''): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $pesan; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card card-custom p-4 bg-white mb-4" style="max-width: 650px;">
            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-circle-plus text-primary me-2"></i> Tambah Akun Baru</h6>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Username</label>
                    <input type="text" name="username" class="form-control form-control-sm" placeholder="Masukkan username..." required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Password</label>
                    <input type="text" name="password" class="form-control form-control-sm" placeholder="Masukkan password..." required>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary-gradient w-100 py-2">Simpan Akun</button>
            </form>
        </div>

        <div class="card card-custom p-4 bg-white">
            <h6 class="fw-bold text-dark mb-3">Daftar Akun Karyawan</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle" style="font-size: 14px;">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">No</th>
                            <th class="py-3">Username</th>
                            <th class="py-3">Password</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?>
                        <?php 
                        $no = 1;
                        if(mysqli_num_rows($data_akun) > 0):
                            while($row = mysqli_fetch_assoc($data_akun)): 
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td class="fw-semibold text-primary"><?php echo $row['username']; ?></td>
                            <td><code><?php echo $row['password']; ?></code></td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm text-white px-2 py-1" style="font-size: 12px; border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#edit<?php echo $row['id']; ?>">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </button>
                                <a href="tambah_akun.php?hapus=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm px-2 py-1" style="font-size: 12px; border-radius: 6px;" onclick="return confirm('Yakin ingin menghapus akun ini?')">
                                    <i class="fa-solid fa-trash me-1"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <div class="modal fade" id="edit<?php echo $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Akun</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Username</label>
                                                <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Password</label>
                                                <input type="text" name="password" class="form-control" value="<?php echo $row['password']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="edit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php 
                            endwhile; 
                        else:
                        ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada akun karyawan yang terdaftar.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>