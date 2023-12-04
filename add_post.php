<?php
require_once 'config.php';
require_once 'functions.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $userId = $_SESSION['user_id'];
    $csrfToken = $_POST['csrf_token'];

    // Validasi CSRF token
    if (!validateCSRFToken($csrfToken)) {
        die('Location: login.php');
    }

    // Validasi input kosong
    if (empty($title) || empty($content) || empty($category)) {
        die("Title, content, and category are required");
    }

    createPost($title, $content, $category, $userId);
    echo "Post added successfully!";
}

$csrfToken = generateToken();
$_SESSION['csrf_token'] = $csrfToken;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Post</title>
</head>
<body>
    <h2>Add Post</h2>

    <nav>
        <ul>
            <li><a href="beranda.php">Admin Panel</a></li>
            <li><a href="add_post.php">Add Post</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <form action="add_post.php" method="post">
        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

        <label for="title">Title:</label>
        <input type="text" name="title" required><br>

        <label for="content">Content:</label>
        <textarea name="content" rows="4" required></textarea><br>

        <label for="category">Category:</label>
        <input type="text" name="category" required><br>

        <button type="submit">Add Post</button>
    </form>

    <br>
    <a href="beranda.php">Back to Admin Panel</a>
</body>
</html>
