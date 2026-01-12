<?php
// src/models/Article.php

class Article {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Get all articles with authors and institutions
    public function getAll() {
        $sql = "
            SELECT a.article_id, a.title, a.abstract, a.keywords, a.references, a.article_type,
                   a.doi, a.pages, a.file, a.article_order,
                   j.year, j.volume, j.edition, j.period, j.file AS journal_file
            FROM article a
            JOIN journal j ON a.journal_id = j.journal_id
            ORDER BY j.year DESC, j.volume DESC, j.edition DESC, a.article_order ASC
        ";
        return $this->pdo->query($sql)->fetchAll();
    }
}
