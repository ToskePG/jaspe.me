<?php
require_once __DIR__ . '/../../src/config/db.php';

$stmt = $pdo->prepare("DELETE FROM journal WHERE journal_id = ?");
$stmt->execute([$_GET['id']]);

header('Location: index.php');
