<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | LAB-SYS Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0dcaf0;
            --secondary-color: #0081a7;
            --bg-gradient: linear-gradient(135deg, #0081a7 0%, #00afb9 100%);
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            z-index: -1;
            animation: float 20s infinite linear;
        }
        .circle-1 { width: 300px; height: 300px; top: -100px; left: -100px; }
        .circle-2 { width: 200px; height: 200px; bottom: -50px; right: -50px; }

        @keyframes float {
            0% { transform: translate(0, 0); }
            50% { transform: translate(30px, 30px); }
            100% { transform: translate(0, 0); }
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            padding: 40px 30px;
            transition: transform 0.3s ease;
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            margin: 0 auto 20px;
            color: white;
            font-size: 35px;
            box-shadow: 0 10px 20px rgba(13, 202, 240, 0.3);
            transform: rotate(-10deg);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
            margin-left: 5px;
        }

        .input-group {
            background: #f1f3f5;
            border-radius: 12px;
            padding: 5px 15px;
            border: 2px solid transparent;
            transition: all 0.3s;
        }

        .input-group:focus-within {
            border-color: var(--primary-color);
            background: white;
            box-shadow: 0 0 0 4px rgba(13, 202, 240, 0.1);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: #adb5bd;
            padding-right: 10px;
        }

        .form-control {
            background: transparent;
            border: none;
            padding: 10px 0;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .form-control:focus {
            box-shadow: none;
            background: transparent;
        }

        .btn-login {
            background: var(--bg-gradient);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-top: 20px;
            color: white;
            transition: all 0.3s;
            box-shadow: 0 10px 20px rgba(0, 129, 167, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(0, 129, 167, 0.4);
            color: white;
        }

        .register-link {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
        }

        .register-link:hover {
            color: #005f73;
            text-decoration: underline;
        }

        .alert {
            border-radius: 12px;
            font-size: 0.85rem;
            border: none;
        }
    </style>
</head>
<body>

    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="text-center mb-4">
                <div class="brand-logo">
                    <i class="fas fa-microscope"></i>
                </div>
                <h3 class="fw-bold mb-0" style="color: #2b2d42;">LAB-SYS</h3>
                <p class="text-muted small">Halo Selamat Datang Di Inventaris Laboratorium</p>
            </div>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/login-auth') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label class="form-label">USERNAME / NIM</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                        <input type="text" name="nim" class="form-control" placeholder="Contoh: 15240425" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">PASSWORD</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-login w-100">MASUK KE SISTEM</button>
            </form>

            <div class="text-center mt-4">
                <p class="small text-muted mb-0">Belum punya akses?</p>
                <a href="<?= base_url('register') ?>" class="register-link">Minta Akun / Daftar Sekarang</a>
            </div>
        </div>
        <p class="text-center mt-4 text-white-50 small">© 2026 LAB-SYS Kelompok 2. All Rights Reserved.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>