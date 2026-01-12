<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

$pdo->beginTransaction();

try {
    // Save main article
    $stmt = $pdo->prepare("INSERT INTO article (journal_id, title, article_type, abstract, keywords, `references`, doi, pages, file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Handle file upload
    $file_name = null;
    if (!empty($_FILES['file']['name'])) {
        $file_name = time() . '_' . basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/uploads/articles/' . $file_name);
    }

    $stmt->execute([
        $_POST['journal_id'],
        $_POST['title'],
        $_POST['article_type'],
        $_POST['abstract'],
        $_POST['keywords'],
        $_POST['references'],
        $_POST['doi'],
        $_POST['pages'],
        $file_name
    ]);

    $article_id = $pdo->lastInsertId();

    // Assign authors (institutions per author will be added later)
    if (!empty($_POST['authors'])) {
        foreach ($_POST['authors'] as $author_id) {
            // Default institution assignment empty for now
            // We can update this per article in future UI
            // For now, just a placeholder
            $stmt = $pdo->prepare("INSERT INTO article_author_institution (article_id, author_id, institution_id) VALUES (?, ?, ?)");
            $stmt->execute([$article_id, $author_id, 1]); // assign first institution by default
        }
    }

    $pdo->commit();
    header('Location: index.php');
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    die("Error: " . $e->getMessage());
}
