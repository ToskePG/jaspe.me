<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

$stmt = $pdo->prepare("DELETE FROM journal WHERE journal_id = ?");
$stmt->execute([$_GET['id']]);

header('Location: index.php');
