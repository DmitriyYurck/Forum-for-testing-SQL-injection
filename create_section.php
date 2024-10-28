<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    $sql = "INSERT INTO sections (name) VALUES ('$name')";

    if ($conn->query($sql) === TRUE) {
        echo "Section created successfully";
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
    <title>Create Section</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>создание узла</h1>
    </header>
    <form method="post" action="create_section.php">
        <input type="text" name="name" placeholder="Section Name" required>
        <button type="submit">Создать узел</button>
    </form>
    <footer>
        <p><a href="index.php">к панели</a></p>
    </footer>
</body>
</html>