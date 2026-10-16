<?php
require 'db.php';

// Handle the login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    // password_verify checks the submitted password against the stored hash
    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: /admin.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<?php require '../templates/header.php'; ?>
<main>
    <h1>Staff Login</h1>
    <?php if (isset($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="/login.php">
        <label>Username</label>
        <input type="text" name="username" required />
        <label>Password</label>
        <input type="password" name="password" required />
        <input type="submit" value="Login" />
    </form>
</main>
<aside></aside>
<?php require '../templates/footer.php'; ?>
