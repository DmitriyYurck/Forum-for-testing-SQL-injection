<?php
include 'includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
    $comment = $_POST['comment'];
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['username'];
    $author = $_SESSION['username'];

    $sql = "INSERT INTO comments (post_id, user_id, comment, author) VALUES ('$post_id', (SELECT id FROM users WHERE username='$user_id'), '$comment', '$author')";

    if ($conn->query($sql) === TRUE) {
        header("Location: posts.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>