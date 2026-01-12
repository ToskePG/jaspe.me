<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | JASPE</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f8;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            border-radius: 8px;
        }
        .logo {
            max-width: 160px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="card shadow login-card">
    <div class="text-center">
        <img src="../assets/images/jaspe_logo.png" alt="JASPE Logo" class="logo">
        <h5 class="mb-3">Admin Login</h5>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center">
            Invalid username or password
        </div>
    <?php endif; ?>

    <form method="POST" action="login_process.php">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Login
        </button>
    </form>
</div>

</body>
</html>
