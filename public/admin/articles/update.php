<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

$article_id = $_POST['article_id'];

$pdo->beginTransaction();
try {
    // Handle file upload
    $file_name = null;
    if (!empty($_FILES['file']['name'])) {
        $file_name = time().'_'.basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/uploads/articles/'.$file_name);
    }

    // Update article
    $sql = "UPDATE article SET journal_id=?, title=?, article_type=?, abstract=?, keywords=?, references=?, doi=?, pages=?";
    $params = [$_POST['journal_id'], $_POST['title'], $_POST['article_type'], $_POST['abstract'], $_POST['keywords'], $_POST['references'], $_POST['doi'], $_POST['pages']];

    if($file_name){
        $sql .= ", file=?";
        $params[] = $file_name;
    }
    $sql .= " WHERE article_id=?";
    $params[] = $article_id;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Remove old author-institution links
    $pdo->prepare("DELETE FROM article_author_institution WHERE article_id=?")->execute([$article_id]);

    // Insert updated author-institution links
    if(!empty($_POST['author_institution'])){
        foreach($_POST['author_institution'] as $author_id => $institutions){
            foreach($institutions as $inst_id){
                $pdo->prepare("INSERT INTO article_author_institution (article_id, author_id, institution_id) VALUES (?, ?, ?)")
                    ->execute([$article_id, $author_id, $inst_id]);
            }
        }
    }

    $pdo->commit();
    header('Location: index.php');
    exit;

} catch(Exception $e){
    $pdo->rollBack();
    die("Error: ".$e->getMessage());
}
