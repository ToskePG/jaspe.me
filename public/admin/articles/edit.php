<?php
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) die("Article ID missing");

// Fetch article
$stmt = $pdo->prepare("SELECT * FROM article WHERE article_id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();
if (!$article) die("Article not found");

// Fetch all journals for select
$journals = $pdo->query("SELECT * FROM journal ORDER BY year DESC, volume DESC, edition DESC")->fetchAll();

// Fetch all authors for multi-select
$authors = $pdo->query("SELECT * FROM author ORDER BY full_name ASC")->fetchAll();

// Fetch all institutions
$institutions = $pdo->query("SELECT * FROM institution ORDER BY institution_name ASC")->fetchAll();

// Fetch assigned authors + institutions for this article
$stmt = $pdo->prepare("SELECT * FROM article_author_institution WHERE article_id = ?");
$stmt->execute([$id]);
$assigned = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC); 
// $assigned[author_id] = array of assigned institutions
?>

<div class="flex-grow-1 content">
    <h2 class="mb-4">Edit Article</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="update.php" enctype="multipart/form-data">
                <input type="hidden" name="article_id" value="<?= $article['article_id'] ?>">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($article['title']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Type</label>
                        <input type="text" name="article_type" class="form-control" value="<?= htmlspecialchars($article['article_type']) ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Journal</label>
                        <select name="journal_id" class="form-select" required>
                            <option value="">Select Journal</option>
                            <?php foreach($journals as $j): ?>
                                <option value="<?= $j['journal_id'] ?>" <?= $article['journal_id'] == $j['journal_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($j['period'].' '.$j['year'].' Vol.'.$j['volume'].' No.'.$j['edition']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pages / Ahead of Print</label>
                        <input type="text" name="pages" class="form-control" value="<?= htmlspecialchars($article['pages']) ?>">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Abstract</label>
                        <textarea name="abstract" class="form-control" rows="4"><?= htmlspecialchars($article['abstract']) ?></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Keywords</label>
                        <input type="text" name="keywords" class="form-control" value="<?= htmlspecialchars($article['keywords']) ?>">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">References</label>
                        <textarea name="references" class="form-control" rows="3"><?= htmlspecialchars($article['references']) ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">DOI</label>
                        <input type="text" name="doi" class="form-control" value="<?= htmlspecialchars($article['doi']) ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Article PDF</label>
                        <input type="file" name="file" class="form-control">
                        <?php if($article['file']): ?>
                            <small class="text-muted">Current: <?= htmlspecialchars($article['file']) ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="form-label">Authors & Institutions</label>
                        <?php foreach($authors as $a): 
                            // fetch institutions for this author in this article
                            $selected_inst = [];
                            if(isset($assigned[$a['author_id']])){
                                foreach($assigned[$a['author_id']] as $row){
                                    $selected_inst[] = $row['institution_id'];
                                }
                            }
                        ?>
                            <div class="mb-2">
                                <strong><?= htmlspecialchars($a['full_name']) ?></strong>
                                <select name="author_institution[<?= $a['author_id'] ?>][]" class="form-select" multiple>
                                    <?php foreach($institutions as $i): ?>
                                        <option value="<?= $i['institution_id'] ?>" <?= in_array($i['institution_id'], $selected_inst) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($i['institution_name'].' ('.$i['country'].')') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endforeach; ?>
                        <small class="text-muted">Assign institutions for each author in this article</small>
                    </div>
                </div>

                <button class="btn btn-primary mt-4">Update Article</button>
                <a href="index.php" class="btn btn-secondary mt-4">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
