<?php
require_once __DIR__ . '/../src/config/db.php';
require_once __DIR__ . '/../src/models/Article.php';

$articleModel = new Article($pdo);
$articles = $articleModel->getAll();

echo "<pre>";
print_r($articles);
echo "</pre>";
