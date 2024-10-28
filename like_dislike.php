<?php
include 'includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
    $thread_id = $_POST['thread_id'];
    $reaction = $_POST['action'];
    $user_id = $_SESSION['username'];

    // Проверка существования реакции
    $check_sql = "SELECT * FROM thread_reactions WHERE thread_id='$thread_id' AND user_id=(SELECT id FROM users WHERE username='$user_id')";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Если реакция уже существует, удаляем её
        $row = $check_result->fetch_assoc();
        if ($row['reaction'] == $reaction) {
            $delete_sql = "DELETE FROM thread_reactions WHERE id='" . $row['id'] . "'";
            $conn->query($delete_sql);
        } else {
            // Если реакция другая, обновляем её
            $update_sql = "UPDATE thread_reactions SET reaction='$reaction' WHERE id='" . $row['id'] . "'";
            $conn->query($update_sql);
        }
    } else {
        // Если реакции нет, добавляем новую
        $insert_sql = "INSERT INTO thread_reactions (thread_id, user_id, reaction) VALUES ('$thread_id', (SELECT id FROM users WHERE username='$user_id'), '$reaction')";
        $conn->query($insert_sql);
    }

    // Обновление счетчика лайков и дизлайков
    $like_count_sql = "SELECT COUNT(*) as count FROM thread_reactions WHERE thread_id='$thread_id' AND reaction='like'";
    $dislike_count_sql = "SELECT COUNT(*) as count FROM thread_reactions WHERE thread_id='$thread_id' AND reaction='dislike'";
    
    $like_count_result = $conn->query($like_count_sql);
    $dislike_count_result = $conn->query($dislike_count_sql);
    
    $likes = $like_count_result->fetch_assoc()['count'];
    $dislikes = $dislike_count_result->fetch_assoc()['count'];
    
    $update_thread_sql = "UPDATE threads SET likes='$likes', dislikes='$dislikes' WHERE id='$thread_id'";
    $conn->query($update_thread_sql);
    
    header("Location: thread.php?id=$thread_id");
    exit;
}
?>