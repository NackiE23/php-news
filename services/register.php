<?php
session_start();
require_once('../database/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($password === $password_confirm) {
        $sql = "INSERT INTO users (email, username, password) VALUES ('$email', '$username', '$hashed_password')";
        $res = $db->exec($sql);

        $errorMsg = $db->lastErrorMsg();

        if ($res) {
            $_SESSION['message'] = ["category" => "success", "text" => "You successfuly registered! Log in please"];
            header('Location: ../views/login.php');
        } else {
            $_SESSION['message'] = ["category" => "danger", "text" => "SQLite Error - $errorMsg"];
            header('Location: ../views/register.php');
        }
    } else {
        $_SESSION['message'] = ["category" => "danger", "text" => "Passwords do not match!"];
        header('Location: ../views/register.php');
    }
}
