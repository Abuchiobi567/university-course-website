<?php
require 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name      = trim($_POST['name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $course_id = (int)($_POST['course_id'] ?? 0);
    $message   = trim($_POST['message'] ?? '');

    // Validate the form fields
    if ($name === '')                               $errors[] = 'Name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email address is required.';
    if ($course_id <= 0)                            $errors[] = 'Please select a course.';
    if ($message === '')                            $errors[] = 'Message is required.';

    if (empty($errors)) {
        $stmt = $pdo->prepare(
            'INSERT INTO enquiries (name, email, phone, course_id, message) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([$name, $email, $phone, $course_id, $message]);

        // Redirect after a successful submit to stop the form re-posting on refresh
        header('Location: /enquiry.php?success=1');
        exit;
    }
}

$courses = $pdo->query('SELECT id, title FROM courses ORDER BY title')->fetchAll();
?>
<?php require '../templates/header.php'; ?>
<main>
    <h1>Make an enquiry</h1>

    <?php if (isset($_GET['success'])): ?>
        <p class="success-msg">Your enquiry has been submitted successfully!</p>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <ul class="error-list">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="/enquiry.php">
        <label>Your name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required />

        <label>Email address</label>
        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required />

        <label>Phone number (optional)</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" />

        <label>Which course are you enquiring about?</label>
        <select name="course_id" required>
            <option value="">-- Select a course --</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?= (int)$course['id'] ?>"
                    <?= ((int)($_POST['course_id'] ?? 0) === (int)$course['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($course['title']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>What do you want to ask?</label>
        <textarea name="message" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>

        <input type="submit" value="Submit enquiry" />
    </form>
</main>
<aside></aside>
<?php require '../templates/footer.php'; ?>
