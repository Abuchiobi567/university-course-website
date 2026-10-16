<?php
require 'db.php';

// Load the subject area from the URL
if (!isset($_GET['id'])) {
    header('Location: /');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM subject_areas WHERE id = ?');
$stmt->execute([$_GET['id']]);
$current_area = $stmt->fetch();

if (!$current_area) {
    header('Location: /');
    exit;
}

// Show 10 courses per page using LIMIT and OFFSET
$limit       = 10;
$page        = max(1, (int)($_GET['page'] ?? 1));
$offset      = ($page - 1) * $limit;

$count_stmt = $pdo->prepare('SELECT COUNT(*) FROM courses WHERE subject_area_id = ?');
$count_stmt->execute([$current_area['id']]);
$total       = (int)$count_stmt->fetchColumn();
$total_pages = $total > 0 ? ceil($total / $limit) : 1;

$stmt = $pdo->prepare(
    'SELECT * FROM courses WHERE subject_area_id = ? ORDER BY title LIMIT ? OFFSET ?'
);
$stmt->bindValue(1, $current_area['id'], PDO::PARAM_INT);
$stmt->bindValue(2, $limit, PDO::PARAM_INT);
$stmt->bindValue(3, $offset, PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll();
?>
<?php require '../templates/header.php'; ?>
<main>
    <h1><?= htmlspecialchars($current_area['name']) ?></h1>

    <?php if ($total === 0): ?>
        <p>No courses have been added to this subject area yet.</p>
    <?php else: ?>

        <?php foreach ($courses as $course): ?>
            <article>
                <h2><?= htmlspecialchars($course['title']) ?></h2>
                <p><strong>Type:</strong> <?= htmlspecialchars($course['type']) ?></p>
                <p><strong>Duration:</strong> <?= (int)$course['duration'] ?> year<?= $course['duration'] != 1 ? 's' : '' ?></p>
                <p><strong>Can be completed part time?</strong> <?= $course['part_time'] ? 'Yes' : 'No' ?></p>
                <p><?= htmlspecialchars($course['description']) ?></p>

                <?php
                // Get the modules for this course
                $mod_stmt = $pdo->prepare(
                    'SELECT m.code, m.title, m.description
                     FROM modules m
                     JOIN course_modules cm ON m.id = cm.module_id
                     WHERE cm.course_id = ?
                     ORDER BY m.code'
                );
                $mod_stmt->execute([$course['id']]);
                $modules = $mod_stmt->fetchAll();
                ?>
                <?php if (!empty($modules)): ?>
                    <h3>Modules</h3>
                    <ul>
                    <?php foreach ($modules as $module): ?>
                        <li>
                            <strong><?= htmlspecialchars($module['code']) ?></strong>:
                            <?= htmlspecialchars($module['title']) ?> &mdash;
                            <?= htmlspecialchars($module['description']) ?>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <a href="/enquiry.php">Make an enquiry</a>
            </article>
        <?php endforeach; ?>

        <?php if ($total_pages > 1): ?>
            <nav class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?id=<?= $current_area['id'] ?>&page=<?= $page - 1 ?>">&laquo; Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?id=<?= $current_area['id'] ?>&page=<?= $i ?>"
                       <?= $i === $page ? 'class="active"' : '' ?>><?= $i ?></a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?id=<?= $current_area['id'] ?>&page=<?= $page + 1 ?>">Next &raquo;</a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>

    <?php endif; ?>
</main>
<aside></aside>
<?php require '../templates/footer.php'; ?>
