<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['username'];

    $sql = "INSERT INTO posts (title, content, author) VALUES ('$title', '$content', '$author')";

    if ($conn->query($sql) === TRUE) {
        echo "Post created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Create a New Post</h1>
    </header>
    <form method="post" action="create_post.php">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="content" placeholder="Content" required></textarea>
        <button type="submit">Создать пост</button>
    </form>
    <footer>
        <p><a href="index.php">Вернуться к панели</a></p>
    </footer>
</body>
</html>