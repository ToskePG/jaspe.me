<?php
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

// Fetch journals for select
$journals = $pdo->query("SELECT * FROM journal ORDER BY year DESC, volume DESC, edition DESC")->fetchAll();

// Fetch authors for multi-select
$authors = $pdo->query("SELECT * FROM author ORDER BY full_name ASC")->fetchAll();

// Fetch institutions for assigning per author
$institutions = $pdo->query("SELECT * FROM institution ORDER BY institution_name ASC")->fetchAll();
?>

<div class="flex-grow-1 content">
    <h2 class="mb-4">Add Article</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="store.php" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Type</label>
                        <input type="text" name="article_type" class="form-control" placeholder="Review / Original Scientific Paper">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Journal</label>
                        <select name="journal_id" class="form-select" required>
                            <option value="">Select Journal</option>
                            <?php foreach($journals as $j): ?>
                                <option value="<?= $j['journal_id'] ?>">
                                    <?= htmlspecialchars($j['period'] . ' ' . $j['year'] . ' Vol.' . $j['volume'] . ' No.' . $j['edition']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pages / Ahead of Print</label>
                        <input type="text" name="pages" class="form-control" placeholder="e.g., 47-65 or Ahead of Print">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Abstract</label>
                        <textarea name="abstract" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Keywords</label>
                        <input type="text" name="keywords" class="form-control" placeholder="keyword1, keyword2">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">References</label>
                        <textarea name="references" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">DOI</label>
                        <input type="text" name="doi" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Article PDF</label>
                        <input type="file" name="file" class="form-control">
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="form-label">Authors (select multiple)</label>
                        <select name="authors[]" class="form-select" multiple required>
                            <?php foreach($authors as $a): ?>
                                <option value="<?= $a['author_id'] ?>"><?= htmlspecialchars($a['full_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-12 mt-3">
                        <small class="text-muted">Institutions assignment will be done per author in the next step</small>
                    </div>
                </div>

                <button class="btn btn-primary mt-4">Save Article</button>
                <a href="index.php" class="btn btn-secondary mt-4">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
