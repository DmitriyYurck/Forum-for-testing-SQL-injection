<?php
include 'includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['username'];
    $section_id = $_POST['section_id'];
    $prefix = $_POST['prefix'];

    $sql = "INSERT INTO threads (title, content, author, section_id, prefix) VALUES ('$title', '$content', '$author', '$section_id', '$prefix')";

    if ($conn->query($sql) === TRUE) {
        echo "Thread created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    header("Location: threads.php");
    exit;
}
?>