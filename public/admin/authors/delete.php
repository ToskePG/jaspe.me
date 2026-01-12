<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM author WHERE author_id = ?");
    $stmt->execute([$id]);
}

header('Location: index.php');
exit;
