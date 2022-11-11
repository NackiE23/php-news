<?php
require_once('../database/db_connection.php');
require('components/header.php');

if ($_GET['id']) {
    $news_id = $_GET['id'];

    $responce = $db->query("
        SELECT news.id, news.created, news.title, news.main_text, news.user_id, users.username
        FROM news
        JOIN users ON news.user_id == users.id
        WHERE news.id = $news_id
    ");
    $news = $responce->fetchArray(SQLITE3_ASSOC);

    $is_owner = $_SESSION['user'] && $_SESSION['user']['id'] === $news['user_id'];

    $is_comments_exist = $db->querySingle("SELECT COUNT(*) as count FROM comments WHERE comments.news_id == $news_id");
    if ($is_comments_exist) {
        $sql = "SELECT comments.id, comments.user_id, comments.main_text, users.username FROM comments
                JOIN users ON comments.user_id == users.id
                WHERE comments.news_id == $news_id";
        $comments = $db->query($sql);
    }
} else {
    header('Location: /');
    exit();
}
?>

<div class="container">
    <!-- News Title -->
    <?php
        if ($_GET['change_title']) {
            echo "<p>
            <form method='POST' action='../services/change_news.php'>
                <input type='hidden' name='news_id' value={$news['id']}>
                <div class='d-flex justify-content-between'>
                    <div class='form-floating flex-grow-1 me-2'>
                      <input class='form-control bg-secondary text-light' name='new_title' placeholder='New Title' id='floatingInput' value=\"{$news['title']}\">
                      <label for='floatingInput'>New Title</label>
                    </div>

                    <input type='submit' class='btn btn-secondary' value='Change'>
                    <a class='btn btn-secondary ms-2 d-flex align-items-center' href='?id=$news_id'>Cancel</a>
                </div>
            </form></p>
            ";
        } else {
            echo '<h1 class="d-flex justify-content-center">';
            echo $news['title'];
            if ($is_owner || $_SESSION['user']['is_admin']) {
                echo "
                <a class='btn btn-secondary ms-2 d-flex align-self-end' href='?id=$news_id&change_title=1'>Change title</a>
                <form class='ms-2' action='../services/delete_news.php' method='POST'>
                    <input type='hidden' name='news_id' value=$news_id>
                    <button class='btn btn-danger' type='submit'>Delete this news</button>
                </form>
                ";
            }
            echo '</h1>';
        }
    ?>
    <!-- News Created -->
    <p>
        Posted by <?= $news['username'] ?> at <?= $news['created'] ?>
    </p>
    <!-- News Main text -->
    <p>
        <?php
            if ($_GET['change_main_text']) {
                echo "
                <form method='POST' action='../services/change_news.php'>
                    <input type='hidden' name='news_id' value={$news['id']}>
                    <div class='d-flex justify-content-between'>
                        <div class='form-floating flex-grow-1 me-2'>
                            <textarea class='form-control bg-secondary text-light' name='new_main_text' placeholder='New Main Text' id='floatingTextarea' style='min-height: 250px;'>{$news['main_text']}</textarea>
                            <label for='floatingTextarea'>New Main Text</label>
                        </div>

                        <input type='submit' class='btn btn-secondary' value='Change'>
                        <a class='btn btn-secondary ms-2 d-flex align-items-center' href='?id=$news_id'>Cancel</a>
                    </div>
                </form>
                ";
            } else {
                echo $news['main_text'];
                if ($is_owner || $_SESSION['user']['is_admin']) {
                    echo "<a class='btn btn-secondary ms-2 d-flex justify-content-center' href='?id=$news_id&change_main_text=1'>Change main text</a>";
                }
            }
        ?>
    </p>
    <!-- News Comments -->
    <hr>
    <h3>Comments</h3>
    <ul class="list-group list-group-flush mb-4">
        <?php
            if ($is_comments_exist) {
                while ($comment = $comments->fetchArray(SQLITE3_ASSOC)) {
                    echo "
                    <li class='list-group-item bg-secondary mb-1'>
                        {$comment['username']}: {$comment['main_text']}";

                    if ($_SESSION['user']['id'] == $comment['user_id'] || $_SESSION['user']['is_admin']) {
                        if ($_GET['change_comment'] == $comment['id']) {
                            echo "
                            <form method='POST' action='../services/change_comment.php'>
                                <input type='hidden' name='news_id' value=$news_id>
                                <input type='hidden' name='comment_id' value={$comment['id']}>
                                <div class='d-flex justify-content-between'>
                                    <div class='form-floating flex-grow-1 me-2'>
                                      <input class='form-control bg-dark text-light' name='new_comment_text' placeholder='New Comment' id='floatingInput' value=\"{$comment['main_text']}\">
                                      <label for='floatingInput' class='text-light'>New Comment</label>
                                    </div>

                                    <input type='submit' class='btn btn-dark' value='Change'>
                                    <a class='btn btn-dark ms-2 d-flex align-items-center' href='?id=$news_id'>Cancel</a>
                                </div>
                            </form>
                            ";
                        } else {
                            echo "
                            <div class='d-flex justify-content-center'>
                                <form action='../services/delete_comment.php' method='POST'>
                                    <input type='hidden' name='news_id' value=$news_id>
                                    <input type='hidden' name='comment_id' value={$comment['id']}>
                                    <button class='btn btn-danger' type='submit'>Delete</button>
                                </form>
                                <a class='btn btn-dark ms-2 d-flex align-self-end' href='?id=$news_id&change_comment={$comment['id']}'>Change comment</a>
                            </div>
                            ";
                        }

                    }

                    echo "</li>";
                }
            } else {
                echo "No comments yet";
            }
        ?>
    </ul>
    <?php
        if ($_SESSION['user']) {
            echo "
            <form method='POST' action='../services/add_comment.php'>
                <input type='hidden' name='user_id' value={$_SESSION['user']['id']}>
                <input type='hidden' name='news_id' value={$news['id']}>
                <div class='form-floating'>
                  <textarea class='form-control bg-secondary mb-2 text-light' name='main_text' placeholder='Leave a comment here' id='floatingTextarea2'></textarea>
                  <label for='floatingTextarea2'>Leave a comment here</label>
                </div>

                <input type='submit' class='btn btn-secondary' value='Add comment'>
            </form>
            ";
        }
    ?>
</div>


<?php require('components/footer.php');
