<?php
require 'db.php';

// Only logged-in users can view enquiries
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

// Mark an enquiry as responded - records who responded using the logged-in username
if (isset($_GET['respond']) && is_numeric($_GET['respond'])) {
    $stmt = $pdo->prepare(
        'UPDATE enquiries SET is_responded = 1, responded_by = ? WHERE id = ?'
    );
    $stmt->execute([$_SESSION['username'], (int)$_GET['respond']]);
    header('Location: /admin-enquiry.php');
    exit;
}

// Get enquiries that have not been responded to yet
$pending = $pdo->query(
    'SELECT e.*, c.title AS course_title
     FROM enquiries e
     JOIN courses c ON e.course_id = c.id
     WHERE e.is_responded = 0
     ORDER BY e.created_at ASC'
)->fetchAll();

// Get enquiries that have already been responded to
$responded = $pdo->query(
    'SELECT e.*, c.title AS course_title
     FROM enquiries e
     JOIN courses c ON e.course_id = c.id
     WHERE e.is_responded = 1
     ORDER BY e.created_at DESC'
)->fetchAll();
?>
<?php require '../templates/header.php'; ?>
<main>
    <h1>Enquiries</h1>

    <h2>Pending (<?= count($pending) ?>)</h2>
    <?php if (empty($pending)): ?>
        <p>No pending enquiries.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Course</th>
                    <th>Message</th>
                    <th>Received</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pending as $enq): ?>
                    <tr>
                        <td><?= htmlspecialchars($enq['name']) ?></td>
                        <td><a href="mailto:<?= htmlspecialchars($enq['email']) ?>"><?= htmlspecialchars($enq['email']) ?></a></td>
                        <td><?= $enq['phone'] !== '' ? htmlspecialchars($enq['phone']) : '&mdash;' ?></td>
                        <td><?= htmlspecialchars($enq['course_title']) ?></td>
                        <td><?= htmlspecialchars($enq['message']) ?></td>
                        <td><?= htmlspecialchars($enq['created_at']) ?></td>
                        <td><a href="/admin-enquiry.php?respond=<?= (int)$enq['id'] ?>">Mark as responded</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h2>Responded (<?= count($responded) ?>)</h2>
    <?php if (empty($responded)): ?>
        <p>No responded enquiries yet.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Message</th>
                    <th>Received</th>
                    <th>Responded by</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($responded as $enq): ?>
                    <tr>
                        <td><?= htmlspecialchars($enq['name']) ?></td>
                        <td><?= htmlspecialchars($enq['email']) ?></td>
                        <td><?= htmlspecialchars($enq['course_title']) ?></td>
                        <td><?= htmlspecialchars($enq['message']) ?></td>
                        <td><?= htmlspecialchars($enq['created_at']) ?></td>
                        <td><?= htmlspecialchars($enq['responded_by']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="/admin.php">Back to Dashboard</a>
</main>
<aside></aside>
<?php require '../templates/footer.php'; ?>
