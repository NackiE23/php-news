<?php
session_start();
require_once('../database/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $news_id = $_POST['news_id'];
    $comment_id = $_POST['comment_id'];
    $new_comment_text = $_POST['new_comment_text'];

    $sql = "UPDATE comments SET main_text = \"$new_comment_text\" WHERE comments.id = $comment_id";
    $res = $db->exec($sql);

    $errorMsg = $db->lastErrorMsg();

    if ($res) {
        $_SESSION['message'] = ["category" => "success", "text" => "Comment has changed!"];
    } else {
        $_SESSION['message'] = ["category" => "danger", "text" => "SQLite Error - $errorMsg"];
    }
    header("Location: ../views/news.php?id=$news_id");
}
