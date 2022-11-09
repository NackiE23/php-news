<?php
    require_once('../database/db_connection.php');
    require('components/header.php');
?>

<h1>Register panel</h1>

<div class="container">
    <form method="POST" action="../services/register.php" enctype="multipart/form-data">
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control bg-secondary" id="email" name="email">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="username" class="col-sm-2 col-form-label">Username: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control bg-secondary" id="username" name="username">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Password: </label>
            <div class="col-sm-10">
                <input type="password" class="form-control bg-secondary" id="password" name="password">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password_confirm" class="col-sm-2 col-form-label">Password confirmation: </label>
            <div class="col-sm-10">
                <input type="password" class="form-control bg-secondary" id="password_confirm" name="password_confirm">
            </div>
        </div>

        <input type="submit" class="btn btn-secondary">
    </form>
</div>

<?php ('components/footer.php');
