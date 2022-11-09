<?php
session_start();
require_once('../database/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, username, password) VALUES ('$email', '$username', '$hashed_password')";
    $res = $db->exec($sql);

    if ($password === $password_confirm) {

        if ($res) {
            $_SESSION['message'] = ["category" => "success", "text" => "You successfuly registered!"];
            header('Location: ../views/login.php');
        } else {
            $_SESSION['message'] = ["category" => "danger", "text" => "User with this email already exists! $sql"];
            header('Location: ../views/register.php');
        }
    } else {
        $_SESSION['message'] = ["category" => "danger", "text" => "Passwords do not match!"];
        header('Location: ../views/register.php');
    }
}
