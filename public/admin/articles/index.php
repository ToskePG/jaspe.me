<?php
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

// Fetch all articles with their journal info
$stmt = $pdo->query("
    SELECT a.article_id, a.title, a.article_type, a.pages, j.period, j.year, j.volume, j.edition
    FROM article a
    JOIN journal j ON a.journal_id = j.journal_id
    ORDER BY j.year DESC, j.volume DESC, j.edition DESC, a.article_id ASC
");
$articles = $stmt->fetchAll();
?>

<div class="flex-grow-1 content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Articles</h2>
        <a href="create.php" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Article
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Journal</th>
                        <th>Pages / Ahead of Print</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $art): ?>
                        <tr>
                            <td><?= htmlspecialchars($art['title']) ?></td>
                            <td><?= htmlspecialchars($art['article_type']) ?></td>
                            <td>
                                <?= htmlspecialchars($art['period'] . ' ' . $art['year'] . ' Vol.' . $art['volume'] . ' No.' . $art['edition']) ?>
                            </td>
                            <td><?= htmlspecialchars($art['pages']) ?></td>
                            <td class="text-end">
                                <a href="edit.php?id=<?= $art['article_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $art['article_id'] ?>" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this article?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
