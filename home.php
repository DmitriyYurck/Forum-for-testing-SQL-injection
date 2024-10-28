<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель пользователя</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Здравствуйте, <?php echo $_SESSION['username']; ?>!</h1>
    </header>
    <nav>
        <a href="posts.php">Посты</a>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="admin/create_post.php">Создать пост</a>
        <?php endif; ?>
        <a href="logout.php">Выйти</a>
    </nav>
</body>
</html>