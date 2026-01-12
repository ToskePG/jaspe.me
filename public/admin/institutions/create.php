<?php
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="flex-grow-1 content">
    <h2 class="mb-4">Add Institution</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="store.php">
                <div class="mb-3">
                    <label class="form-label">Institution Name</label>
                    <input type="text" name="institution_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control">
                </div>

                <button class="btn btn-primary">Save</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
