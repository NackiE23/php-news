<?php
session_start();
require_once('../database/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $news_id = $_POST['news_id'];
    $new_title = $_POST['new_title'];
    $new_main_text = $_POST['new_main_text'];

    if ($new_title && $new_main_text) {
        $sql = "UPDATE news SET title = \"$new_title\", main_text = \"$new_main_text\" WHERE news.id = $news_id";
    } elseif ($new_title) {
        $sql = "UPDATE news SET title = \"$new_title\" WHERE news.id = $news_id";
    } elseif ($new_main_text) {
        $sql = "UPDATE news SET main_text = \"$new_main_text\" WHERE news.id = $news_id";
    } else {
        $_SESSION['message'] = ["category" => "danger", "text" => "Something wrong. Try again!"];
        header("Location: ../views/news.php?id=$news_id");
        exit();
    }

    $res = $db->exec($sql);

    $errorMsg = $db->lastErrorMsg();

    if ($res) {
        $_SESSION['message'] = ["category" => "success", "text" => "Your news has changed!"];
    } else {
        $_SESSION['message'] = ["category" => "danger", "text" => "SQLite Error - $errorMsg"];
    }
    header("Location: ../views/news.php?id=$news_id");
}
