<?php
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
require_once __DIR__ . '/../../src/config/db.php';

$stmt = $pdo->query("
    SELECT * FROM journal
    ORDER BY year DESC, volume DESC, edition DESC
");
$journals = $stmt->fetchAll();
?>

<div class="flex-grow-1 content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Journals</h2>
        <a href="create.php" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Journal
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>Year</th>
                    <th>Volume</th>
                    <th>Edition</th>
                    <th>Period</th>
                    <th>File</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($journals as $j): ?>
                    <tr>
                        <td><?= $j['year'] ?></td>
                        <td><?= $j['volume'] ?></td>
                        <td><?= $j['edition'] ?></td>
                        <td><?= htmlspecialchars($j['period']) ?></td>
                        <td>
                            <?php if ($j['file']): ?>
                                <a href="/uploads/full_issues/<?= $j['file'] ?>" target="_blank">Download</a>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="edit.php?id=<?= $j['journal_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete.php?id=<?= $j['journal_id'] ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this journal?')">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
