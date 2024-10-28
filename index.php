<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Панель админа</h1>
    </header>
    <nav>
        <a href="create_section.php">Create Section</a>
        <a href="create_post.php">Create Post</a>
    </nav>
    <footer>
        <p><a href="../home.php">Домой</a></p>
    </footer>
</body>
</html>