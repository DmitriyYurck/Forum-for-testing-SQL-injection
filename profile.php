<?php
include 'includes/db.php';
session_start();

if (!isset($_GET['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_GET['username'];
$user_sql = "SELECT * FROM users WHERE username='$username'";
$user_result = $conn->query($user_sql);

if ($user_result->num_rows == 0) {
    header("Location: index.php");
    exit;
}

$user = $user_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $user['username']; ?>'s Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1><?php echo $user['username']; ?>'s Profile</h1>
    </header>
    <div class="profile">
        <img src="avatars/<?php echo $user['avatar']; ?>" alt="Avatar">
        <p>Status: <?php echo $user['status']; ?></p>
        <p>Description: <?php echo $user['description']; ?></p>
        <p>Topics Created: <?php echo $user['topic_count']; ?></p>
        <p>Total Likes: <?php echo $user['total_likes']; ?></p>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <a href='admin/edit_profile.php?username=<?php echo $user['username']; ?>'>Редактировать профиль</a>
        <?php endif; ?>
    </div>
</body>
</html>