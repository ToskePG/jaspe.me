<?php
require_once __DIR__ . '/layout/header.php';
require_once __DIR__ . '/layout/sidebar.php';
?>

<div class="flex-grow-1 content">
    <h2 class="mb-4">Dashboard</h2>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Journals</h6>
                    <h3>—</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Articles</h6>
                    <h3>—</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Authors</h6>
                    <h3>—</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
