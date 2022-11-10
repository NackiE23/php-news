<?php
session_start();

if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
    $_SESSION['message'] = ["category" => "success", "text" => "You successfuly logged out!"];
}

header('Location: /');
