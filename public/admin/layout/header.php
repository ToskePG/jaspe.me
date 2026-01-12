<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: /admin/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel | JASPE</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fa;
        }
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #1f2933;
        }
        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #334155;
            color: #fff;
        }
        .sidebar .active {
            background: #2563eb;
            color: #fff;
        }
        .content {
            padding: 30px;
        }
        .brand-logo {
            max-width: 140px;
        }
    </style>
</head>
<body>
<div class="d-flex">
