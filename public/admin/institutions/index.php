<?php
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

$stmt = $pdo->query("SELECT * FROM institution ORDER BY institution_name ASC");
$institutions = $stmt->fetchAll();
?>

<div class="flex-grow-1 content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Institutions</h2>
        <a href="create.php" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Institution
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Country</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($institutions as $i): ?>
                        <tr>
                            <td><?= htmlspecialchars($i['institution_name']) ?></td>
                            <td><?= htmlspecialchars($i['country']) ?></td>
                            <td class="text-end">
                                <a href="edit.php?id=<?= $i['institution_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $i['institution_id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this institution?')">
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
