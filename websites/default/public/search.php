<?php
require 'db.php';

$query          = trim($_GET['q'] ?? '');
$part_time_only = isset($_GET['part_time']) && $_GET['part_time'] === '1';
$results        = [];
$searched       = false;
$total          = 0;
$total_pages    = 1;

// Show 10 results per page using LIMIT and OFFSET
$limit  = 10;
$page   = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

if ($query !== '') {
    $searched = true;
    $like     = '%' . $query . '%';

    // Build the WHERE clause - add part-time filter if the checkbox is ticked
    if ($part_time_only) {
        $where = 'WHERE (c.title LIKE ? OR c.description LIKE ?) AND c.part_time = 1';
    } else {
        $where = 'WHERE c.title LIKE ? OR c.description LIKE ?';
    }

    // Count total results so we know how many pages there are
    $count_stmt = $pdo->prepare(
        "SELECT COUNT(*) FROM courses c JOIN subject_areas s ON c.subject_area_id = s.id $where"
    );
    $count_stmt->execute([$like, $like]);
    $total       = (int)$count_stmt->fetchColumn();
    $total_pages = $total > 0 ? ceil($total / $limit) : 1;

    $stmt = $pdo->prepare(
        "SELECT c.id, c.title, c.type, c.duration, c.description, c.part_time, s.name AS subject_area
         FROM courses c
         JOIN subject_areas s ON c.subject_area_id = s.id
         $where
         ORDER BY c.title
         LIMIT ? OFFSET ?"
    );
    $stmt->bindValue(1, $like);
    $stmt->bindValue(2, $like);
    $stmt->bindValue(3, $limit, PDO::PARAM_INT);
    $stmt->bindValue(4, $offset, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll();
}
?>
<?php require '../templates/header.php'; ?>
<main>
    <h1>Search courses</h1>

    <form method="GET" action="/search.php">
        <label>Search by keyword</label>
        <input type="text" name="q" value="<?= htmlspecialchars($query) ?>" placeholder="e.g. Software, Engineering..." />
        <label>
            <input type="checkbox" name="part_time" value="1" <?= $part_time_only ? 'checked' : '' ?> />
            Part-time only
        </label>
        <input type="submit" value="Search" />
    </form>

    <?php if ($searched): ?>
        <?php if (empty($results)): ?>
            <p>No courses found for "<strong><?= htmlspecialchars($query) ?></strong>".</p>
        <?php else: ?>
            <p>
                <?= $total ?> course<?= $total === 1 ? '' : 's' ?> found
                for "<strong><?= htmlspecialchars($query) ?></strong>"
                <?= $part_time_only ? '(part-time only)' : '' ?>
            </p>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Subject Area</th>
                        <th>Type</th>
                        <th>Duration</th>
                        <th>Part-time</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $course): ?>
                        <tr>
                            <td><?= htmlspecialchars($course['title']) ?></td>
                            <td><?= htmlspecialchars($course['subject_area']) ?></td>
                            <td><?= htmlspecialchars($course['type']) ?></td>
                            <td><?= (int)$course['duration'] ?> year<?= $course['duration'] != 1 ? 's' : '' ?></td>
                            <td><?= $course['part_time'] ? 'Yes' : 'No' ?></td>
                            <td><?= htmlspecialchars($course['description']) ?></td>
                            <td><a href="/enquiry.php">Enquire</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ($total_pages > 1): ?>
                <nav class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?q=<?= urlencode($query) ?>&part_time=<?= $part_time_only ? '1' : '0' ?>&page=<?= $page - 1 ?>">&laquo; Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?q=<?= urlencode($query) ?>&part_time=<?= $part_time_only ? '1' : '0' ?>&page=<?= $i ?>"
                           <?= $i === $page ? 'class="active"' : '' ?>><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?q=<?= urlencode($query) ?>&part_time=<?= $part_time_only ? '1' : '0' ?>&page=<?= $page + 1 ?>">Next &raquo;</a>
                    <?php endif; ?>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</main>
<aside></aside>
<?php require '../templates/footer.php'; ?>
