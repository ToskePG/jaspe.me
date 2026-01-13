<?php
require_once __DIR__ . '/../src/config/db.php';

// Base folder for article files
$baseUploads = 'uploads/'; // relative to public_html

/**
 * 1. Get latest journal
 */
$journalStmt = $pdo->query("
    SELECT *
    FROM journal
    ORDER BY year DESC, volume DESC, edition DESC
    LIMIT 1
");
$journal = $journalStmt->fetch();

if (!$journal) {
    die('No journal found.');
}

/**
 * 2. Get articles for this journal with authors
 */
$articleStmt = $pdo->prepare("
    SELECT 
        a.article_id,
        a.title,
        a.abstract,
        a.article_type,
        a.doi,
        a.pages,
        a.file,
        GROUP_CONCAT(au.full_name ORDER BY aa.author_order SEPARATOR ', ') AS authors
    FROM article a
    LEFT JOIN article_author aa ON a.article_id = aa.article_id
    LEFT JOIN author au ON aa.author_id = au.author_id
    WHERE a.journal_id = ?
    GROUP BY a.article_id
    ORDER BY a.article_order ASC
");
$articleStmt->execute([$journal['journal_id']]);
$articles = $articleStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>JASPE Journal</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --bg: #0b0d1a;
    --card: rgba(255,255,255,0.08);
    --accent: #6c63ff;
    --muted: #9fa3c7;
    --text: #ffffff;
}

* { box-sizing: border-box; }

body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #0b0d1a, #151836);
    color: var(--text);
}

a { text-decoration: none; color: inherit; }

/* NAV */
header {
    padding: 24px 80px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

header img { height: 42px; }

nav a {
    margin-left: 36px;
    color: var(--muted);
    font-weight: 500;
}

nav a:hover { color: var(--accent); }

/* HERO */
.hero {
    max-width: 1300px;
    margin: auto;
    padding: 70px 80px;
}

.hero h1 {
    font-size: 3rem;
    max-width: 800px;
}

.hero p {
    color: var(--muted);
    max-width: 600px;
    margin-top: 18px;
}

/* ARTICLES */
.section {
    max-width: 1300px;
    margin: auto;
    padding: 60px 80px;
}

.section h2 {
    font-size: 2rem;
    margin-bottom: 40px;
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
}

/* ARTICLE CARD */
.card {
    background: var(--card);
    border-radius: 22px;
    padding: 28px;
    backdrop-filter: blur(18px);
    transition: transform .35s ease, box-shadow .35s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 40px 80px rgba(0,0,0,.4);
}

.card h3 {
    font-size: 1.3rem;
    margin-bottom: 10px;
}

.card .authors {
    font-size: 0.9rem;
    color: var(--accent);
    margin-bottom: 12px;
}

.card .journal-info {
    font-size: 0.85rem;
    color: var(--muted);
    margin-bottom: 12px;
}

.card .abstract {
    color: var(--muted);
    font-size: 0.95rem;
    line-height: 1.5;
    margin-bottom: 18px;
}

.meta {
    font-size: 0.85rem;
    display: flex;
    justify-content: space-between;
    color: #b6b9e5;
}

.card .download-btn {
    display: inline-block;
    margin-top: 18px;
    padding: 10px 18px;
    border-radius: 999px;
    background: var(--accent);
    color: #fff;
    font-weight: 600;
    font-size: 0.85rem;
    text-align: center;
}

/* FOOTER */
footer {
    text-align: center;
    padding: 40px;
    color: var(--muted);
    font-size: 0.85rem;
}

@media (max-width: 768px) {
    header, .hero, .section { padding: 40px 30px; }
    .hero h1 { font-size: 2.2rem; }
}
</style>
</head>
<body>

<header>
    <img src="assets/images/jaspe_logo-removebg-preview.png" alt="JASPE">
    <nav>
        <a href="#">Home</a>
        <a href="#">Journal</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
    </nav>
</header>

<section class="hero">
    <h1>Journal of Anthropology of Sport and Physical Education</h1>
    <p>
        Volume <?= $journal['volume']; ?> · Edition <?= $journal['edition']; ?>
        (<?= htmlspecialchars($journal['period']); ?> <?= $journal['year']; ?>)
    </p>
</section>

<section class="section">
    <h2>Latest Articles</h2>

    <div class="grid">
        <?php foreach ($articles as $article): 
            $articleUrl = 'article.php?id=' . $article['article_id'];
            $pdfUrl = $article['file'] ? $baseUploads . $article['file'] : null;
        ?>
            <div class="card" onclick="window.location='<?= $articleUrl ?>'">
                <h3><?= htmlspecialchars($article['title']); ?></h3>

                <div class="authors">
                    <?= htmlspecialchars($article['authors']); ?>
                </div>

                <div class="journal-info">
                    Volume <?= $journal['volume']; ?> · Edition <?= $journal['edition']; ?> · <?= htmlspecialchars($journal['period']); ?> <?= $journal['year']; ?>
                </div>

                <div class="abstract">
                    <?= nl2br(htmlspecialchars($article['abstract'])); ?>
                </div>

                <div class="meta">
                    <span><?= htmlspecialchars($article['article_type']); ?></span>
                    <span><?= htmlspecialchars($article['pages']); ?></span>
                </div>

                <?php if ($pdfUrl): ?>
                    <a class="download-btn" href="<?= htmlspecialchars($pdfUrl); ?>" target="_blank" onclick="event.stopPropagation();">
                        Download PDF
                    </a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<footer>
    © <?= date('Y'); ?> JASPE Journal. All rights reserved.
</footer>

</body>
</html>
