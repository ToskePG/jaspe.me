<?php
require_once __DIR__ . '/../../src/config/db.php';

$fileName = null;

if (!empty($_FILES['file']['name'])) {
    $fileName = time() . '_' . basename($_FILES['file']['name']);
    move_uploaded_file(
        $_FILES['file']['tmp_name'],
        __DIR__ . '/../../uploads/full_issues/' . $fileName
    );
}

$stmt = $pdo->prepare("
    INSERT INTO journal (year, volume, edition, period, file)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->execute([
    $_POST['year'],
    $_POST['volume'],
    $_POST['edition'],
    $_POST['period'],
    $fileName
]);

header('Location: index.php');
exit;
