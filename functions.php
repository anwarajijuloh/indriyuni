<?php
session_start();

function generateToken() {
    return bin2hex(random_bytes(32));
}

function registerUser($name, $username, $email, $password) {
    global $pdo;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, username, email, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $username, $email, $hashedPassword]);
}

function loginUser($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user['id'];
    }

    return false;
}


function logout() {
    session_start();
    session_destroy();
    header('Location: login.php');
    exit();
}


function createPost($title, $content, $category, $userId) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO posts (title, content, category, user_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $content, $category, $userId]);
}

function getPosts() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM posts");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function redirectToLogin() {
    header("Location: login.php");
    exit();
}

function redirectToBlog() {
    header("Location: blog.php");
    exit();
}
function redirectToAdmin() {
    header("Location: beranda.php");
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function validatePassword($password, $confirmPassword) {
    return $password === $confirmPassword;
}

function validateUserExists($username, $email) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    return $stmt->fetch() !== false;
}
?>
