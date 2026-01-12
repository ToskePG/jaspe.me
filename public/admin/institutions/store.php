<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

$stmt = $pdo->prepare("INSERT INTO institution (institution_name, country) VALUES (?, ?)");
$stmt->execute([
    $_POST['institution_name'],
    $_POST['country']
]);

header('Location: index.php');
exit;
