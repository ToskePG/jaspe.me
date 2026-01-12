<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

$id = $_POST['id'];
$fileSql = '';

if (!empty($_FILES['file']['name'])) {
    $fileName = time() . '_' . basename($_FILES['file']['name']);
    move_uploaded_file(
        $_FILES['file']['tmp_name'],
        __DIR__ . '/../../uploads/full_issues/' . $fileName
    );
    $fileSql = ", file = '$fileName'";
}

$pdo->exec("
    UPDATE journal SET
    year = {$_POST['year']},
    volume = {$_POST['volume']},
    edition = {$_POST['edition']},
    period = '{$$_POST['period']}'
    $fileSql
    WHERE journal_id = $id
");

header('Location: index.php');
