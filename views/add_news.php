<?php
    session_start();

    if (!isset($_SESSION['user'])) {
        header('Location: /');
        exit();
    } else {
        require_once('../database/db_connection.php');
        require('components/header.php');
    }
?>

<h1>Add News panel</h1>

<div class="container">
    <form method="POST" action="../services/add_news.php" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value=<?= $_SESSION['user']['id'] ?>>
        <div class="mb-3 row">
            <label for="title" class="col-sm-2 col-form-label">Title: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control bg-secondary" id="title" name="title">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="main_text" class="col-sm-2 col-form-label">Main text: </label>
            <div class="col-sm-10">
                <textarea class="form-control bg-secondary" id="main_text" name="main_text" rows="8" cols="80"></textarea>
            </div>
        </div>

        <input type="submit" class="btn btn-secondary">
    </form>
</div>

<?php ('components/footer.php');
