<?php
session_start();
require_once('../database/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];

    $sql = "DELETE FROM users Where id == $user_id";
    $res = $db->exec($sql);

    $errorMsg = $db->lastErrorMsg();

    if ($res) {
        $_SESSION['message'] = ["category" => "success", "text" => "User successfuly deleted!"];
    } else {
        $_SESSION['message'] = ["category" => "danger", "text" => "SQLite Error - $errorMsg"];
    }
    header("Location: ../views/user_list.php");
}
