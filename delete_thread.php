<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Экранирование ввода для защиты от SQL-инъекций
    $id = $conn->real_escape_string($id);

    // Удаление комментариев, связанных с темой
    $sql_delete_comments = "DELETE FROM comments WHERE post_id IN (SELECT id FROM posts WHERE section_id='$id')";
    if ($conn->query($sql_delete_comments) === TRUE) {
        echo "Comments deleted successfully<br>";
    } else {
        echo "Error: " . $sql_delete_comments . "<br>" . $conn->error;
    }

    // Удаление темы
    $sql = "DELETE FROM threads WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Thread deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
header("Location: ../threads.php");
exit;
?>