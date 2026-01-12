<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

$pdo->beginTransaction();

try {
    // Handle file upload
    $file_name = null;
    if (!empty($_FILES['file']['name'])) {
        $file_name = time() . '_' . basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/uploads/articles/' . $file_name);
    }

    // Insert main article (escape `references` column)
    $stmt = $pdo->prepare("
        INSERT INTO article 
        (journal_id, title, article_type, abstract, keywords, `references`, doi, pages, file)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
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

    // Assign authors + institutions
    if (!empty($_POST['author_institution'])) {
        // $_POST['author_institution'] = [ author_id => [institution_id1, institution_id2, ...], ... ]
        foreach ($_POST['author_institution'] as $author_id => $institution_ids) {
            foreach ($institution_ids as $inst_id) {
                $pdo->prepare("
                    INSERT INTO article_author_institution (article_id, author_id, institution_id)
                    VALUES (?, ?, ?)
                ")->execute([$article_id, $author_id, $inst_id]);
            }
        }
    }

    $pdo->commit();
    header('Location: index.php');
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    die("Error: " . $e->getMessage());
}
