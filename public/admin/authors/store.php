<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

$stmt = $pdo->prepare("INSERT INTO author (full_name, institution_id) VALUES (?, ?)");
$stmt->execute([
    $_POST['full_name'],
    $_POST['institution_id']
]);

header('Location: index.php');
exit;
