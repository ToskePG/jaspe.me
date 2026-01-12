<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../src/config/db.php';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM author WHERE author_id = ?");
$stmt->execute([$id]);
$author = $stmt->fetch();

if (!$author) {
    die("Author not found");
}
?>

<div class="flex-grow-1 content">
    <h2 class="mb-4">Edit Author</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="update.php">
                <input type="hidden" name="author_id" value="<?= $author['author_id'] ?>">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($author['full_name']) ?>" required>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
