<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

$stmt = $pdo->prepare("UPDATE author SET full_name = ? WHERE author_id = ?");
$stmt->execute([
    $_POST['full_name'],
    $_POST['author_id']
]);

header('Location: index.php');
exit;
