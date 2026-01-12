<?php
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="flex-grow-1 content">
    <h2 class="mb-4">Add Journal</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="store.php" enctype="multipart/form-data">

                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Year</label>
                        <input type="number" name="year" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Volume</label>
                        <input type="number" name="volume" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Edition</label>
                        <input type="number" name="edition" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Period</label>
                        <input type="text" name="period" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Full Issue PDF</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                </div>

                <button class="btn btn-primary mt-4">Save</button>
                <a href="index.php" class="btn btn-secondary mt-4">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
