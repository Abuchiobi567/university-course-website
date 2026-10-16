<?php
require 'db.php';

// Only logged-in users can manage courses
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

// Add a new course or update an existing one
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_course'])) {
    $part_time = isset($_POST['part_time']) ? 1 : 0;

    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare(
            'UPDATE courses SET subject_area_id=?, title=?, type=?, duration=?, description=?, part_time=? WHERE id=?'
        );
        $stmt->execute([
            $_POST['subject_area_id'],
            $_POST['title'],
            $_POST['type'],
            $_POST['duration'],
            $_POST['description'],
            $part_time,
            $_POST['id']
        ]);
    } else {
        $stmt = $pdo->prepare(
            'INSERT INTO courses (subject_area_id, title, type, duration, description, part_time) VALUES (?,?,?,?,?,?)'
        );
        $stmt->execute([
            $_POST['subject_area_id'],
            $_POST['title'],
            $_POST['type'],
            $_POST['duration'],
            $_POST['description'],
            $part_time
        ]);
    }
    header('Location: /manage-courses.php');
    exit;
}

// Add a module to the course currently being edited
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_module'])) {
    $course_id = (int)$_POST['course_id'];

    // Create the module record
    $stmt = $pdo->prepare('INSERT INTO modules (code, title, description) VALUES (?, ?, ?)');
    $stmt->execute([$_POST['module_code'], $_POST['module_title'], $_POST['module_description']]);
    $module_id = (int)$pdo->lastInsertId();

    // Link it to the course via the junction table
    $stmt = $pdo->prepare('INSERT INTO course_modules (course_id, module_id) VALUES (?, ?)');
    $stmt->execute([$course_id, $module_id]);

    header('Location: /manage-courses.php?edit=' . $course_id);
    exit;
}

// Remove a module from a course (only removes the link, not the module itself)
if (isset($_GET['remove_module'], $_GET['course_id'])) {
    $stmt = $pdo->prepare('DELETE FROM course_modules WHERE course_id = ? AND module_id = ?');
    $stmt->execute([(int)$_GET['course_id'], (int)$_GET['remove_module']]);
    header('Location: /manage-courses.php?edit=' . (int)$_GET['course_id']);
    exit;
}

// Delete a course and its module links
if (isset($_GET['delete'])) {
    $pdo->prepare('DELETE FROM course_modules WHERE course_id = ?')->execute([$_GET['delete']]);
    $pdo->prepare('DELETE FROM courses WHERE id = ?')->execute([$_GET['delete']]);
    header('Location: /manage-courses.php');
    exit;
}

// Load the course being edited (if any)
$editing         = null;
$editing_modules = [];
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM courses WHERE id = ?');
    $stmt->execute([$_GET['edit']]);
    $editing = $stmt->fetch();

    if ($editing) {
        // Get the modules linked to this course
        $stmt = $pdo->prepare(
            'SELECT m.id, m.code, m.title, m.description
             FROM modules m
             JOIN course_modules cm ON m.id = cm.module_id
             WHERE cm.course_id = ?
             ORDER BY m.code'
        );
        $stmt->execute([$editing['id']]);
        $editing_modules = $stmt->fetchAll();
    }
}

// Work out which page we're on and calculate the LIMIT/OFFSET for the query
$limit       = 10;
$page        = max(1, (int)($_GET['page'] ?? 1));
$offset      = ($page - 1) * $limit;
$total       = (int)$pdo->query('SELECT COUNT(*) FROM courses')->fetchColumn();
$total_pages = $total > 0 ? ceil($total / $limit) : 1;

$stmt = $pdo->prepare(
    'SELECT c.*, s.name AS area_name
     FROM courses c
     JOIN subject_areas s ON c.subject_area_id = s.id
     ORDER BY s.name, c.title
     LIMIT ? OFFSET ?'
);
$stmt->bindValue(1, $limit, PDO::PARAM_INT);
$stmt->bindValue(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll();

$areas = $pdo->query('SELECT * FROM subject_areas ORDER BY name')->fetchAll();
?>
<?php require '../templates/header.php'; ?>
<main>
    <h1>Manage Courses</h1>

    <h2><?= $editing ? 'Edit Course' : 'Add New Course' ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $editing ? $editing['id'] : '' ?>" />

        <label>Subject Area</label>
        <select name="subject_area_id">
            <?php foreach ($areas as $area): ?>
                <option value="<?= $area['id'] ?>"
                    <?= ($editing && $editing['subject_area_id'] == $area['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($area['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Title</label>
        <input type="text" name="title" value="<?= $editing ? htmlspecialchars($editing['title']) : '' ?>" required />

        <label>Type (BSc, MSc, BA, MA)</label>
        <input type="text" name="type" value="<?= $editing ? htmlspecialchars($editing['type']) : '' ?>" required />

        <label>Duration (years)</label>
        <input type="number" name="duration" value="<?= $editing ? $editing['duration'] : '' ?>" required />

        <label>Description</label>
        <textarea name="description"><?= $editing ? htmlspecialchars($editing['description']) : '' ?></textarea>

        <label>
            <input type="checkbox" name="part_time" value="1"
                <?= ($editing && $editing['part_time']) ? 'checked' : '' ?> />
            Available part-time
        </label>

        <input type="submit" name="save_course" value="<?= $editing ? 'Update Course' : 'Add Course' ?>" />
    </form>

    <?php if ($editing): ?>
        <!-- Module management only shows when editing an existing course -->
        <h3>Modules for this course</h3>
        <?php if (empty($editing_modules)): ?>
            <p>No modules added yet.</p>
        <?php else: ?>
            <ul>
            <?php foreach ($editing_modules as $module): ?>
                <li>
                    <strong><?= htmlspecialchars($module['code']) ?></strong>:
                    <?= htmlspecialchars($module['title']) ?> &mdash;
                    <?= htmlspecialchars($module['description']) ?>
                    <a href="/manage-courses.php?remove_module=<?= $module['id'] ?>&course_id=<?= $editing['id'] ?>">Remove</a>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <h4>Add a module</h4>
        <form method="POST">
            <input type="hidden" name="course_id" value="<?= $editing['id'] ?>" />
            <label>Module Code</label>
            <input type="text" name="module_code" placeholder="e.g. CSY2089" required />
            <label>Module Title</label>
            <input type="text" name="module_title" required />
            <label>Short Description</label>
            <input type="text" name="module_description" required />
            <input type="submit" name="add_module" value="Add Module" />
        </form>
    <?php endif; ?>

    <h2>Existing Courses</h2>
    <p>Showing <?= count($courses) ?> of <?= $total ?> courses</p>
    <ul>
    <?php foreach ($courses as $course): ?>
        <li>
            <strong><?= htmlspecialchars($course['title']) ?></strong>
            (<?= htmlspecialchars($course['type']) ?>,
            <?= (int)$course['duration'] ?> year<?= $course['duration'] != 1 ? 's' : '' ?><?= $course['part_time'] ? ', part-time available' : '' ?>)
            &mdash; <?= htmlspecialchars($course['area_name']) ?>
            <a href="/manage-courses.php?edit=<?= $course['id'] ?>">Edit</a>
            <a href="/manage-courses.php?delete=<?= $course['id'] ?>">Delete</a>
        </li>
    <?php endforeach; ?>
    </ul>

    <?php if ($total_pages > 1): ?>
        <nav class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>">&laquo; Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" <?= $i === $page ? 'class="active"' : '' ?>><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>

    <a href="/admin.php">Back to Dashboard</a>
</main>
<aside></aside>
<?php require '../templates/footer.php'; ?>
