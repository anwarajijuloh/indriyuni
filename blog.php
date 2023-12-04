<?php
require_once 'config.php';
require_once 'functions.php';

$posts = getPosts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog</title>
</head>
<body>
    <h2>Blog</h2>
    <?php foreach ($posts as $post): ?>
        <div>

            <h3><?= $post['title'] ?></h3>
            <p><?= $post['content'] ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>
