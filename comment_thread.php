<?php
include 'includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
    $comment = $_POST['comment'];
    $thread_id = $_POST['thread_id'];
    $author = $_SESSION['username'];

    // Проверка, что комментарий не пустой
    if (empty($comment)) {
        echo "Комментарий не может быть пустым.";
        exit;
    }

    $sql = "INSERT INTO thread_comments (thread_id, user_id, comment, author) VALUES ('$thread_id', (SELECT id FROM users WHERE username='$author' LIMIT 1), '$comment', '$author')";

    if ($conn->query($sql) === TRUE) {
        header("Location: thread.php?id=$thread_id");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>