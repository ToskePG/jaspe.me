<?php
session_start();

// Protect the page
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | JASPE</title>
</head>
<body>

<h1>Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?></h1>

<p>This is the admin dashboard.</p>

<ul>
    <li><a href="#">Manage Journals</a></li>
    <li><a href="#">Manage Articles</a></li>
    <li><a href="#">Manage Authors</a></li>
</ul>

<p><a href="logout.php">Logout</a></p>

</body>
</html>
