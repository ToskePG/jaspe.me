<?php
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';

// Fetch institutions for select box
$institutions = $pdo->query("SELECT * FROM institution ORDER BY institution_name ASC")->fetchAll();
?>

<div class="flex-grow-1 content">
    <h2 class="mb-4">Add Author</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="store.php">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Institution</label>
                    <select name="institution_id" class="form-select" required>
                        <option value="">Select Institution</option>
                        <?php foreach ($institutions as $i): ?>
                            <option value="<?= $i['institution_id'] ?>"><?= htmlspecialchars($i['institution_name']) ?> (<?= htmlspecialchars($i['country']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button class="btn btn-primary">Save</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
