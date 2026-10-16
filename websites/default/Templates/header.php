<?php
require_once __DIR__ . '/../public/db.php';

// Load subject areas for the navigation menu
$areas = $pdo->query('SELECT * FROM subject_areas ORDER BY name')->fetchAll();
?>
<!doctype html>
<html>
<head>
    <title>University of Northampton</title>
    <link rel="stylesheet" href="/uon.css" />
</head>
<body>
    <header>
        <img src="/logo.jpg" alt="logo" />
        <ul>
            <li><a href="/">Home</a></li>
            <li>Subject Areas
                <ul>
                    <?php foreach ($areas as $area): ?>
                        <li>
                            <a href="/subject-area.php?id=<?= $area['id'] ?>">
                                <?= htmlspecialchars($area['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li><a href="/search.php">Search</a></li>
            <li><a href="/enquiry.php">Make an enquiry</a></li>
        </ul>
    </header>
    <section></section>
