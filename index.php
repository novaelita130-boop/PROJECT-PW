<?php
session_start();
if (isset($_SESSION['status_login']) && $_SESSION['status_login'] === true) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: karyawan/dashboard.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - PAYROLLKU</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body, html { height: 100vh; margin: 0; font-family: 'Poppins', sans-serif; background-color: #f8fafc; }
        .split-screen { display: flex; height: 100vh; width: 100vw; }
        
        .leftside {
            flex: 1;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            text-align: center;
        }

        .leftside h1 {
            font-weight: 700;
            letter-spacing: 1px;
            background: linear-gradient(to right, #ffffff, #93c5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .rightside {
            flex: 1;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .form-control {
            padding: 12px 15px 12px 45px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .input-group-icon {
            position: absolute;
            left: 16px;
            top: 42px;
            z-index: 10;
            color: #64748b;
        }

        .btn-login {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
            width: 100%;
            color: white;
            transition: opacity 0.2s;
        }

        .btn-login:hover {
            opacity: 0.9;
            color: white;
        }

        @media (max-width: 768px) {
            .split-screen { flex-direction: column; }
            .leftside { display: none; }
        }
    </style>
</head>
<body>

    <div class="split-screen">
        <div class="leftside">
            <div class="mb-4">
                <div class="bg-white bg-opacity-10 p-4 rounded-circle d-inline-block shadow-sm">
                    <i class="fa-solid fa-users fa-3x text-white"></i>
                </div>
            </div>
            <h1 class="display-6 mb-2">PAYROLLKU</h1>
            <p class="text-light opacity-90 fs-6 fw-light">Sistem Informasi Penggajian Karyawan Profesional</p>
        </div>

        <div class="rightside">
            <div class="login-container">
                <div class="mb-4">
                    <h3 class="fw-bold text-dark mb-1">Login Akun</h3>
                    <p class="text-muted small">Silakan masukkan username dan password Anda</p>
                </div>

                <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'salah'): ?>
                    <div class="alert alert-danger py-2 small rounded-3" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-1"></i> Username atau Password salah!
                    </div>
                <?php endif; ?>

                <form action="cek_login.php" method="POST">
                    <div class="mb-3 position-relative">
                        <span class="input-group-icon"><i class="fa-solid fa-user"></i></span>
                        <label class="form-label small fw-semibold text-secondary">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autocomplete="off">
                    </div>

                    <div class="mb-4 position-relative">
                        <span class="input-group-icon"><i class="fa-solid fa-lock"></i></span>
                        <label class="form-label small fw-semibold text-secondary">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>

                    <button type="submit" class="btn btn-login shadow-sm">Masuk Sistem</button>
                </form>

                <div class="text-center mt-4">
                    <small class="text-muted">&copy; 2026 PAYROLLKU. All Rights Reserved.</small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>