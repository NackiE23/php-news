<?php
session_start();
require_once('../database/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email LIKE '$email'";
    $responce = $db->query($sql);

    if ($responce) {
        $result = $responce->fetchArray(SQLITE3_ASSOC);

        if (password_verify($password, $result['password'])) {
            $_SESSION['user'] = $result;
            $_SESSION['message'] = ["category" => "success", "text" => "You successfuly logged in, {$result['username']}!"];
            header('Location: /');
        } else {
            $_SESSION['message'] = ["category" => "danger", "text" => "Wrong password or email!"];
            header('Location: ../views/login.php');
        }
    } else {
        $_SESSION['message'] = ["category" => "danger", "text" => "Wrong password or email!"];
        header('Location: ../views/register.php');
    }
}
