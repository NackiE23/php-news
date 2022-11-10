<?php
session_start();
require_once('../database/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $created = date('Y-m-d H:i');
    $user_id = $_POST['user_id'];
    $title = $_POST['title'];
    $main_text = $_POST['main_text'];

    $sql = "INSERT INTO news (created, title, main_text, user_id) VALUES ('$created', '$title', '$main_text', '$user_id')";
    $res = $db->exec($sql);

    $errorMsg = $db->lastErrorMsg();

    if ($res) {
        $_SESSION['message'] = ["category" => "success", "text" => "Your news added!"];
    } else {
        $_SESSION['message'] = ["category" => "danger", "text" => "SQLite Error - $errorMsg"];
    }
    header('Location: /');
}
