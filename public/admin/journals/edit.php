<?php
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
require_once __DIR__ . '/../../src/config/db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM journal WHERE journal_id = ?");
$stmt->execute([$id]);
$journal = $stmt->fetch();
?>

<div class="flex-grow-1 content">
    <h2>Edit Journal</h2>

    <form method="POST" action="update.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $journal['journal_id'] ?>">

        <input class="form-control mb-2" name="year" value="<?= $journal['year'] ?>">
        <input class="form-control mb-2" name="volume" value="<?= $journal['volume'] ?>">
        <input class="form-control mb-2" name="edition" value="<?= $journal['edition'] ?>">
        <input class="form-control mb-2" name="period" value="<?= htmlspecialchars($journal['period']) ?>">

        <input type="file" name="file" class="form-control mb-3">

        <button class="btn btn-primary">Update</button>
    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
