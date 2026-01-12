<?php
// src/config/db.php

$host = 'localhost';             // Usually 'localhost' for Hostinger MySQL
$db   = 'u101631602_journal_db'; // Database name from screenshot
$user = 'u101631602_danilot';    // MySQL user from screenshot
$pass = 'DomainExpansion17';      // Replace with the password you set on Hostinger
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    exit('Database connection failed: ' . $e->getMessage());
}
