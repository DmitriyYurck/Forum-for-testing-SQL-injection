<?php
include 'includes/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>All Posts</h1>
    </header>
    <div class="posts">
        <?php
        $sql = "SELECT * FROM posts ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($post = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<h2>" . $post['title'] . "</h2>";
                echo "<p>" . $post['content'] . "</p>";
                echo "<p><em>By " . $post['author'] . " on " . $post['created_at'] . "</em></p>";

                if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                    echo "<a href='admin/delete_post.php?id=" . $post['id'] . "'>Delete Post</a>";
                }

                // Комментарии
                $post_id = $post['id'];
                $comment_sql = "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY created_at ASC";
                $comment_result = $conn->query($comment_sql);

                if ($comment_result->num_rows > 0) {
                    echo "<h3>Comments:</h3>";
                    while ($comment = $comment_result->fetch_assoc()) {
                        echo "<p><strong>" . $comment['author'] . ":</strong> " . $comment['comment'] . " <em>on " . $comment['created_at'] . "</em></p>";
                    }
                }

                // Форма комментариев
                if (isset($_SESSION['username'])) {
                    echo "<form method='post' action='comment.php'>
                        <textarea name='comment' placeholder='Add a comment'></textarea>
                        <input type='hidden' name='post_id' value='$post_id'>
                        <button type='submit'>Post Comment</button>
                      </form>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>No posts found</p>";
        }
        ?>
    </div>
</body>
</html>