<?php
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

$stmt = $pdo->query("
    SELECT a.author_id, a.full_name, i.institution_name, i.country 
    FROM author a
    JOIN institution i ON a.institution_id = i.institution_id
    ORDER BY a.full_name ASC
");
$authors = $stmt->fetchAll();
?>

<div class="flex-grow-1 content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Authors</h2>
        <a href="create.php" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Author
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Institution</th>
                        <th>Country</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($authors as $a): ?>
                        <tr>
                            <td><?= htmlspecialchars($a['full_name']) ?></td>
                            <td><?= htmlspecialchars($a['institution_name']) ?></td>
                            <td><?= htmlspecialchars($a['country']) ?></td>
                            <td class="text-end">
                                <a href="edit.php?id=<?= $a['author_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $a['author_id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this author?')">
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
