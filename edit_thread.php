<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: ../threads.php");
    exit;
}

$thread_id = $_GET['id'];
$thread_sql = "SELECT * FROM threads WHERE id='$thread_id'";
$thread_result = $conn->query($thread_sql);

if ($thread_result->num_rows == 0) {
    header("Location: ../threads.php");
    exit;
}

$thread = $thread_result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE threads SET title='$title', content='$content' WHERE id='$thread_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../thread.php?id=$thread_id");
        exit;
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
    <title>Edit Thread</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>редактировать</h1>
    </header>
    <form method="post" action="edit_thread.php?id=<?php echo $thread_id; ?>">
        <input type="text" name="title" value="<?php echo $thread['title']; ?>" required>
        <textarea name="content" required><?php echo $thread['content']; ?></textarea>
        <button type="submit">обновить</button>
    </form>
    <footer>
        <p><a href="../threads.php">вернуться к темам</a></p>
    </footer>
</body>
</html>