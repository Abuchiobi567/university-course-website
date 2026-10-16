<?php
require 'db.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}
?>
<?php require '../templates/header.php'; ?>

<main>
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</p>

    <ul>
        <li><a href="/manage-users.php">Manage Users</a></li>
        <li><a href="/subject-areas.php">Manage Subject Areas</a></li>
        <li><a href="/manage-courses.php">Manage Courses</a></li>
        <li><a href="/admin-enquiry.php">View Enquiries</a></li>
    </ul>

    <a href="/logout.php">Logout</a>
</main>

<aside></aside>

<?php require '../templates/footer.php'; ?>
