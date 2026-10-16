<?php
require 'db.php';

// Only logged-in users can manage subject areas
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

// Add a new subject area or update an existing one
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare('UPDATE subject_areas SET name = ? WHERE id = ?');
        $stmt->execute([$_POST['name'], $_POST['id']]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO subject_areas (name) VALUES (?)');
        $stmt->execute([$_POST['name']]);
    }
}

// Delete a subject area
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM subject_areas WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
}

// Load the subject area to edit (if an edit link was clicked)
$editing = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM subject_areas WHERE id = ?');
    $stmt->execute([$_GET['edit']]);
    $editing = $stmt->fetch();
}

$areas = $pdo->query('SELECT * FROM subject_areas ORDER BY name')->fetchAll();
?>
<?php require '../templates/header.php'; ?>
<main>
    <h1>Manage Subject Areas</h1>

    <h2><?= $editing ? 'Edit Subject Area' : 'Add New Subject Area' ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $editing ? $editing['id'] : '' ?>" />
        <label>Name</label>
        <input type="text" name="name" value="<?= $editing ? htmlspecialchars($editing['name']) : '' ?>" required />
        <input type="submit" value="<?= $editing ? 'Update' : 'Add' ?>" />
    </form>

    <h2>Existing Subject Areas</h2>
    <ul>
    <?php foreach ($areas as $area): ?>
        <li>
            <?= htmlspecialchars($area['name']) ?>
            <a href="/subject-areas.php?edit=<?= $area['id'] ?>">Edit</a>
            <a href="/subject-areas.php?delete=<?= $area['id'] ?>">Delete</a>
        </li>
    <?php endforeach; ?>
    </ul>

    <a href="/admin.php">Back to Dashboard</a>
</main>
<aside></aside>
<?php require '../templates/footer.php'; ?>
