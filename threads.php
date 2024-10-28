<?php
include 'includes/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threads</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Все темы</h1>
    </header>
    <div class="search-bar">
        <form method="get" action="threads.php">
            <input type="text" name="search" placeholder="Search threads">
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="threads">
        <?php
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $sql = "SELECT * FROM threads WHERE title LIKE '%$search%' ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($thread = $result->fetch_assoc()) {
                echo "<div class='thread'>";
                echo "<h2><span class='prefix'>" . $thread['prefix'] . "</span> <a href='thread.php?id=" . $thread['id'] . "'>" . $thread['title'] . "</a></h2>";
                echo "<p><em>By " . $thread['author'] . " on " . $thread['created_at'] . "</em></p>";

                if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                    echo "<a href='admin/delete_thread.php?id=" . $thread['id'] . "'>Delete Thread</a> | ";
                    echo "<a href='admin/edit_thread.php?id=" . $thread['id'] . "'>Edit Thread</a>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>Не найдена</p>";
        }
        ?>
    </div>

    <?php if (isset($_SESSION['username'])): ?>
        <div class="create-thread">
            <h2>Создать тему</h2>
            <form method="post" action="create_thread.php">
                <input type="text" name="title" placeholder="Название" required>
                <textarea name="content" placeholder="Content" required></textarea>
                <select name="section_id" required>
                    <?php
                    $section_sql = "SELECT * FROM sections";
                    $section_result = $conn->query($section_sql);
                    while ($section = $section_result->fetch_assoc()) {
                        echo "<option value='" . $section['id'] . "'>" . $section['name'] . "</option>";
                    }
                    ?>
                </select>
                <select name="prefix" required>
                    <option value="Открыто">Открыто</option>
                    <option value="Закрыто">Закрыто</option>
                    <option value="Актуально">Актуально</option>
                    <option value="Важно">Важно</option>
                </select>
                <button type="submit">Создать</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>