<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Index</title>
    <style type="text/css">
        body {
            padding-bottom: 20px;
            background-color: #212121;
            color: white;
        }
        .news {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid white;
            transition: .3s;
            background-color: #262626;
        }
        .news:hover {
            box-shadow: 0 1px 10px white;
        }
    </style>
</head>
<body class="text-center">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">News</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup" style="margin-right: 20px;">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                    if ($_SESSION['user']) {
                        echo "
                        <li class='nav-item'>
                            <a class='nav-link' href='/views/add_news.php'>Add news</a>
                        </li>
                        ";
                    }
                    if ($_SESSION['user']['is_admin']) {
                        echo "
                        <li class='nav-item'>
                            <a class='nav-link' href='/views/user_list.php'>Users</a>
                        </li>
                        ";
                    }
                    ?>
               </ul>
            </div>
            <div class="d-flex">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                        if ($_SESSION['user']) {
                            echo "
                            <li class='nav-item d-flex align-items-center'>
                                Welcome, {$_SESSION['user']['username']}
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link' href='/services/logout.php'>Log Out</a>
                            </li>";
                        } else {
                            echo "
                            <li class='nav-item'>
                                <a class='nav-link' href='/views/login.php'>Log In</a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link' href='/views/register.php'>Register</a>
                            </li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php
        if ($_SESSION['message']) {
            echo "
            <div class='alert alert-{$_SESSION['message']['category']} alert-dismissible fade show' role='alert'>
                {$_SESSION['message']['text']}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        unset($_SESSION['message']);
    ?>
