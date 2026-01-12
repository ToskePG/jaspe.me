<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

$id = $_GET['id'] ?? null;
if($id){
    // Delete article, article_author_institution will cascade
    $stmt = $pdo->prepare("DELETE FROM article WHERE article_id=?");
    $stmt->execute([$id]);
}

header('Location: index.php');
exit;
