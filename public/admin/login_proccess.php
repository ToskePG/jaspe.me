<?php
session_start();
require_once __DIR__ . '/../../src/config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$username = trim($_POST['username']);
$password = $_POST['password'];

if ($username === '' || $password === '') {
    header('Location: login.php?error=1');
    exit;
}

$sql = "SELECT admin_id, username, password_hash
        FROM admin
        WHERE username = :username
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username]);
$admin = $stmt->fetch();

if ($admin && password_verify($password, $admin['password_hash'])) {
    // Login success
    $_SESSION['admin_id'] = $admin['admin_id'];
    $_SESSION['admin_username'] = $admin['username'];

    header('Location: dashboard.php');
    exit;
}

// Login failed
header('Location: login.php?error=1');
exit;
