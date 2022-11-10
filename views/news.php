<?php
session_start();
require_once('../database/db_connection.php');
require('components/header.php');

if (isset($_GET['id'])) {
    $news_id = $_GET['id'];

    $responce = $db->query("
        SELECT news.id, news.created, news.title, news.main_text, news.user_id, users.username
        FROM news
        JOIN users ON news.user_id == users.id
        WHERE news.id = $news_id
    ");
    $news = $responce->fetchArray(SQLITE3_ASSOC);
    
    $owner = isset($_SESSION['user']) && $_SESSION['user']['id'] === $news['user_id'];

    $is_comment_exists = $db->querySingle("SELECT COUNT(*) as count FROM comments WHERE comments.news_id == $news_id");
    if ($is_comment_exists) {
        $sql = "SELECT comments.main_text, users.username FROM comments JOIN users ON comments.user_id == users.id WHERE comments.news_id == $news_id";
        $comments = $db->query($sql);
    }
} else {
    header('Location: /');
    exit();
}
?>

<div class="container">
    <h1>
        <?php
            echo $news['title'];
            if ($owner) {
                echo ' <a class="btn btn-danger" href="#">Delete this news</a>';
            }
        ?>
    </h1>
    <p>Posted by <?= $news['username'] ?> at <?= $news['created'] ?></p>
    <p><?= $news['main_text'] ?></p>
    <hr>
    <h3>Comments</h3>
    <ul class="list-group list-group-flush mb-4">
        <?php
            if ($is_comment_exists) {
                while ($comment = $comments->fetchArray(SQLITE3_ASSOC)) {
                    echo "<li class='list-group-item bg-secondary mb-1'>{$comment['username']}: {$comment['main_text']}</li>";
                }
            } else {
                echo "No comments yet";
            }
        ?>
    </ul>
    <form method="POST" action="../services/add_comment.php">
        <input type="hidden" name="user_id" value=<?= $_SESSION['user']['id'] ?>>
        <input type="hidden" name="news_id" value=<?= $news['id'] ?>>
        <div class="form-floating">
          <textarea class="form-control bg-secondary mb-2" name="main_text" placeholder="Leave a comment here" id="floatingTextarea2" style="color: white"></textarea>
          <label for="floatingTextarea2">Leave a comment here</label>
        </div>

        <input type="submit" class="btn btn-secondary" value="Add comment">
    </form>
</div>


<?php require('components/footer.php');
