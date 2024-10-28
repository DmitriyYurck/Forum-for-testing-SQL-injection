<?php
include 'includes/db.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: threads.php");
    exit;
}

$thread_id = $_GET['id'];
$thread_sql = "SELECT * FROM threads WHERE id='$thread_id'";
$thread_result = $conn->query($thread_sql);

if ($thread_result->num_rows == 0) {
    header("Location: threads.php");
    exit;
}

$thread = $thread_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $thread['title']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1><span class="prefix"><?php echo $thread['prefix']; ?></span> <?php echo $thread['title']; ?></h1>
        <p><em>By <?php echo $thread['author']; ?> on <?php echo $thread['created_at']; ?></em></p>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <a href='admin/delete_thread.php?id=<?php echo $thread['id']; ?>'>Delete Thread</a> | 
            <a href='admin/edit_thread.php?id=<?php echo $thread['id']; ?>'>Edit Thread</a>
        <?php endif; ?>
    </header>
    <div class="content">
        <p><?php echo nl2br($thread['content']); ?></p>
    </div>
    <div class="likes-dislikes">
        <?php if (!isset($_SESSION['username']) || $_SESSION['username'] !== $thread['author']): ?>
            <form method="post" action="like_dislike.php">
                <input type="hidden" name="thread_id" value="<?php echo $thread_id; ?>">
                <button type="submit" name="action" value="like">👍 <?php echo $thread['likes']; ?></button>
                <button type="submit" name="action" value="dislike">👎 <?php echo $thread['dislikes']; ?></button>
            </form>
        <?php endif; ?>
    </div>
    <div class="comments">
        <h2>Комментарии</h2>
        <?php
        $comment_sql = "SELECT * FROM thread_comments WHERE thread_id='$thread_id' ORDER BY created_at ASC";
        $comment_result = $conn->query($comment_sql);

        if ($comment_result->num_rows > 0) {
            while ($comment = $comment_result->fetch_assoc()) {
                $author_class = ($comment['author'] == 'admin') ? 'admin-comment' : '';
                echo "<div class='comment $author_class'>";
                echo "<p><strong>" . $comment['author'] . ":</strong> " . $comment['comment'] . " <em> создано в " . $comment['created_at'] . "</em></p>";
                echo "</div>";
            }
        } else {
            echo "<p>нет комментариев</p>";
        }
        ?>
    </div>
    <?php if (isset($_SESSION['username'])): ?>
        <div class="add-comment">
            <h2>Добавить комментарий</h2>
            <form method="post" action="comment_thread.php">
                <textarea name="comment" placeholder="Add a comment" required></textarea>
                <input type="hidden" name="thread_id" value="<?php echo $thread_id; ?>">
                <button type="submit">Опубликовать </button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>