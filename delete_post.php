<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $id = $conn->real_escape_string($id);

    $sql = "DELETE FROM posts WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Успешно удален";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}
header("Location: ../posts.php");
exit;
?>