<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

// Insert new author
$stmt = $pdo->prepare("INSERT INTO author (full_name) VALUES (?)");
$stmt->execute([ $_POST['full_name'] ]);

header('Location: index.php');
exit;
