<?php
session_start();
require_once('../database/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $news_id = $_POST['news_id'];
    $user_id = $_POST['user_id'];
    $main_text = $_POST['main_text'];

    $sql = "INSERT INTO comments (main_text, news_id, user_id) VALUES ('$main_text', $news_id, $user_id)";
    $res = $db->exec($sql);

    $errorMsg = $db->lastErrorMsg();

    if ($res) {
        $_SESSION['message'] = ["category" => "success", "text" => "Your comment added!"];
    } else {
        $_SESSION['message'] = ["category" => "danger", "text" => "SQLite Error - $errorMsg"];
    }
    header("Location: ../views/news.php?id=$news_id");
}
