<?php
    require_once('db_connection.php');

    $email = 'sdf3@gmail.com';
    $username = 'sdf3';
    $password = 'sdf3';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, username, password) VALUES ('$email', '$username', '$hashed_password')";
    $res = $db->exec($sql);

    echo $res;
