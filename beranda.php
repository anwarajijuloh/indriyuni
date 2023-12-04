<?php
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

function getUserPosts($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllPosts() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM posts");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function deletePost($postId) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$postId]);
}

$userId = $_SESSION['user_id'];
$userPosts = getUserPosts($userId);
$allPosts = getAllPosts();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $postId = $_POST['post_id'];

    $csrfToken = $_POST['csrf_token'];
    if (!validateCSRFToken($csrfToken)) {
        die(header('Location: login.php'));
    }

    switch ($action) {
        case 'edit':
            header('Location: edit_post.php');

            break;

        case 'delete':
            deletePost($postId);
            break;

        default:
            break;
    }
}

$csrfToken = generateToken();
$_SESSION['csrf_token'] = $csrfToken;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
</head>
<body>
    <h2>Welcome, Admin!</h2>

    <nav>
        <ul>
            <li><a href="beranda.php">Manage Posts</a></li>
            <li><a href="add_post.php">Add Post</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <h3>Your Posts:</h3>
    <?php foreach ($userPosts as $post): ?>
        <div>
            <h4><?= $post['title'] ?></h4>
            <p><?= $post['content'] ?></p>
            <form action="edit_post.php" method="post">
                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                <button type="submit">Edit</button>
            </form>
            <form action="beranda.php" method="post">
                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                <button type="submit">Delete</button>
            </form>
        </div>
    <?php endforeach; ?>

    <h3>All Posts:</h3>
    <?php foreach ($allPosts as $post): ?>
        <div>
            <h4><?= $post['title'] ?></h4>
            <p><?= $post['content'] ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>