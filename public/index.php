<?php
require_once __DIR__ . '/../src/config/db.php';

$baseUploads = 'uploads/';

// Get latest journal
$journalStmt = $pdo->query("
    SELECT *
    FROM journal
    ORDER BY year DESC, volume DESC, edition DESC
    LIMIT 1
");
$journal = $journalStmt->fetch();

if (!$journal) die('No journal found.');

// Get latest 5 articles
$articleStmt = $pdo->prepare("
    SELECT 
        a.article_id, a.title, a.abstract, a.article_type, a.doi, a.pages, a.file,
        GROUP_CONCAT(au.full_name ORDER BY aa.author_order SEPARATOR ', ') AS authors
    FROM article a
    LEFT JOIN article_author aa ON a.article_id = aa.article_id
    LEFT JOIN author au ON aa.author_id = au.author_id
    WHERE a.journal_id = ?
    GROUP BY a.article_id
    ORDER BY a.article_order DESC
    LIMIT 5
");
$articleStmt->execute([$journal['journal_id']]);
$articles = $articleStmt->fetchAll();

// Example partners — replace with your actual logos
$partners = [
    'assets/images/logo.jpg',
    'assets/images/logo.jpg',
    'assets/images/logo.jpg',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>JASPE Journal</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --bg: #0b0d1a;
    --card: rgba(255,255,255,0.08);
    --accent: #6c63ff;
    --muted: #9fa3c7;
    --text: #ffffff;
    --text-alt: #e0e0e0;
}

* { box-sizing: border-box; }

body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #0b0d1a, #151836);
    color: var(--text);
    line-height: 1.6;
}

a { text-decoration: none; color: inherit; }

/* NAVIGATION */
header {
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    background: rgba(11,13,26,0.95);
    backdrop-filter: blur(10px);
    z-index: 999;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 80px;
}

header img { height: 42px; }

nav {
    display: flex;
    align-items: center;
    gap: 32px;
}

nav a {
    font-weight: 500;
    color: var(--text-alt);
    transition: color 0.3s;
}

nav a:hover { color: var(--accent); }

.burger {
    display: none;
    flex-direction: column;
    cursor: pointer;
    gap: 5px;
}

.burger div {
    width: 25px;
    height: 3px;
    background: var(--text-alt);
    transition: 0.3s;
}

/* HERO */
.hero {
    max-width: 1100px;
    margin: 120px auto 60px;
    padding: 0 40px;
}

.hero h1 {
    font-size: 2.8rem;
    margin-bottom: 24px;
    line-height: 1.2;
}

.hero p {
    color: var(--text-alt);
    font-size: 1rem;
    margin-bottom: 20px;
    white-space: pre-line;
}

/* ARTICLES */
.section {
    max-width: 1200px;
    margin: 80px auto;
    padding: 0 40px;
}

.section h2 {
    font-size: 2rem;
    margin-bottom: 40px;
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px,1fr));
    gap: 30px;
}

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

/* FULL ISSUE */
.full-issue {
    text-align: center;
    margin: 80px auto;
}

.full-issue a {
    display: inline-block;
    padding: 14px 24px;
    background: var(--accent);
    color: #fff;
    font-weight: 600;
    border-radius: 999px;
    transition: background 0.3s;
}

.full-issue a:hover { background: #574fd2; }

/* PARTNERS */
.partners {
    max-width: 1200px;
    margin: 80px auto;
    padding: 0 100px;
    text-align: center;
}

.partners h2 { margin-bottom: 40px; }

.partners-logos {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 100px;
}

.partners-logos img {
    max-height: 160px;
    filter: brightness(2)
    transition: transform 0.3s;
}

.partners-logos img:hover { transform: scale(1.5); }

/* FOOTER */
footer {
    text-align: center;
    padding: 60px 40px;
    color: var(--muted);
    font-size: 0.85rem;
}

/* RESPONSIVE */
@media(max-width: 992px){
    header { padding: 18px 40px; }
}

@media(max-width: 768px){
    header { padding: 18px 24px; }
    nav { position: fixed; top: 0; left: -100%; height: 100vh; width: 250px; background: rgba(11,13,26,0.95); flex-direction: column; padding: 100px 24px; gap: 24px; transition: left 0.3s; }
    nav.show { left: 0; }
    .burger { display: flex; }
    .grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<header>
    <img src="assets/images/jaspe_logo.png" alt="JASPE">
    <div class="burger" onclick="toggleMenu(this)">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <nav id="menu">
        <a href="#">Home</a>
        <a href="#">Journal</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
    </nav>
</header>

<section class="hero">
    <h1>Journal of Anthropology of Sport and Physical Education</h1>
    <p>
        Journal of Anthropology of Sport and Physical Education (JASPE) was founded in 2017 and to this day 257 scientific papers of researches from all continents have been published in it.

        In 2018, the editorial board has been strengthened, and this will be done continuously so the journal would grow constantly. Today, Journal of Anthropology of Sport and Physical Education (JASPE) is indexed into seven international databases, of which the most significant are DOAJ and Index Copernicus, and it must be pointed out that, at the moment, it is also passing through the evaluation process in the Scopus database, and this process will be completed very soon.

        Since 2017, each scientific paper has got a recognizable DOI number. Editor-in-chief is Fidanka Vasileva who is performing this function from the beggining of 2021. A new and modern design of PDF papers has been done for the July issue of 2018, and since January issue of 2019 the Editorial Board has reached the decision to publish 10 papers per issue. Since January issue of 2021 the Editorial Board reached the decision to reduce the number of published papers on five. The last five published papers, will be contained at the home page of the site. Also, the statistic of the journal was introduced, where the latest statistical indicators can be viewed. The system of downloading papers in PDF format is modern; bar codes for each paper have been introduced, while the number of visits and downloads are visible. Also, under each paper a discussion forum was introduced, where readers can post their comments and suggestions that can improve the quality of the journal.

        We thank all readers of Journal of Anthropology of Sport and Physical Education (JASPE) and we are confident that this latest edition will be informative enough.

        Editor-in-Chief
        Fidanka Vasileva
    </p>
    <p>
        Volume <?= $journal['volume']; ?> · Edition <?= $journal['edition']; ?> (<?= htmlspecialchars($journal['period']); ?> <?= $journal['year']; ?>)
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

<section class="full-issue">
    <h2>Download Full Issue</h2>
    <?php if(!empty($journal['file'])): ?>
        <a href="<?= $baseUploads . htmlspecialchars($journal['file']); ?>" target="_blank">Download Full PDF Issue</a>
    <?php else: ?>
        <p>No full issue PDF available</p>
    <?php endif; ?>
</section>

<section class="partners">
    <h2>Our Partners</h2>
    <div class="partners-logos">
        <?php foreach($partners as $logo): ?>
            <img src="<?= htmlspecialchars($logo); ?>" alt="Partner logo">
        <?php endforeach; ?>
    </div>
</section>

<footer>
    © <?= date('Y'); ?> JASPE Journal. All rights reserved.
</footer>

<script>
function toggleMenu(el){
    document.getElementById('menu').classList.toggle('show');
    el.classList.toggle('active');
}
</script>

</body>
</html>
