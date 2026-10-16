<?php
require 'db.php';

// Only superadmins can manage user accounts
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'superadmin') {
    header('Location: /login.php');
    exit;
}

// Add a new user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    // password_hash creates a secure hash - we never store the plain password
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
    $stmt->execute([$_POST['username'], $hash, $_POST['role']]);
}

// Delete a user - the WHERE prevents deleting superadmin accounts
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ? AND role != "superadmin"');
    $stmt->execute([$_GET['delete']]);
}

$users = $pdo->query('SELECT * FROM users')->fetchAll();
?>
<?php require '../templates/header.php'; ?>
<main>
    <h1>Manage Users</h1>
    <h2>Add New User</h2>
    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required />
        <label>Password</label>
        <input type="password" name="password" required />
        <label>Role</label>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="superadmin">Superadmin</option>
        </select>
        <input type="submit" name="add" value="Add User" />
    </form>

    <h2>Existing Users</h2>
    <ul>
    <?php foreach ($users as $user): ?>
        <li>
            <?= htmlspecialchars($user['username']) ?> (<?= $user['role'] ?>)
            <?php if ($user['role'] !== 'superadmin'): ?>
                <a href="/manage-users.php?delete=<?= $user['id'] ?>">Delete</a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>

    <a href="/admin.php">Back to Dashboard</a>
</main>
<aside></aside>
<?php require '../templates/footer.php'; ?>
