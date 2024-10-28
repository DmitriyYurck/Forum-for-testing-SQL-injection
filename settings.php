<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST['description'];
    $username = $_SESSION['username'];
    
    // Загрузка аватарки
    $avatar = $_FILES['avatar']['name'];
    $target = "avatars/" . basename($avatar);
    move_uploaded_file($_FILES['avatar']['tmp_name'], $target);

    $sql = "UPDATE users SET description='$description', avatar='$avatar' WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        echo "Profile updated successfully";
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
    <title>Settings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Settings</h1>
    </header>
    <form method="post" action="settings.php" enctype="multipart/form-data">
        <textarea name="description" placeholder="Update your description"></textarea>
        <input type="file" name="avatar">
        <button type="submit">Update Profile</button>
    </form>
    <footer>
        <p><a href="profile.php?username=<?php echo $_SESSION['username']; ?>">Back to Profile</a></p>
    </footer>
</body>
</html>