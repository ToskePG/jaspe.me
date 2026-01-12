<?php
// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get current script path
$current_page = $_SERVER['SCRIPT_NAME']; // e.g., /admin/journals/index.php
?>

<div class="sidebar p-3">
    <div class="text-center mb-4">
        <img src="/assets/images/jaspe_logo.png" class="brand-logo mb-2" alt="JASPE">
        <div class="text-white fw-bold">Admin Panel</div>
    </div>

    <ul class="nav nav-pills flex-column gap-1">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="/admin/dashboard.php" class="nav-link <?= strpos($current_page, '/admin/dashboard.php') !== false ? 'active' : '' ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <!-- Journals -->
        <li class="nav-item">
            <a href="/admin/journals/index.php" class="nav-link <?= strpos($current_page, '/admin/journals/') !== false ? 'active' : '' ?>">
                <i class="bi bi-journal-text me-2"></i> Journals
            </a>
        </li>

        <!-- Articles -->
        <li class="nav-item">
            <a href="/admin/articles/index.php" class="nav-link <?= strpos($current_page, '/admin/articles/') !== false ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-text me-2"></i> Articles
            </a>
        </li>

        <!-- Authors -->
        <li class="nav-item">
            <a href="/admin/authors/index.php" class="nav-link <?= strpos($current_page, '/admin/authors/') !== false ? 'active' : '' ?>">
                <i class="bi bi-people me-2"></i> Authors
            </a>
        </li>

        <!-- Logout -->
        <li class="nav-item mt-3">
            <a href="/admin/logout.php" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>
    </ul>
</div>
