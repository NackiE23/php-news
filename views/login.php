<?php
    require_once('../database/db_connection.php');
    require('components/header.php');

?>

<h1>Login panel</h1>

<div class="container">
    <form method="POST" action="../services/login.php" enctype="multipart/form-data">
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email: </label>
            <div class="col-sm-10">
                <input type="email" class="form-control bg-secondary" id="email" name="email">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Password: </label>
            <div class="col-sm-10">
                <input type="password" class="form-control bg-secondary" id="password" name="password">
            </div>
        </div>

        <input type="submit" class="btn btn-secondary">
    </form>
</div>

<?php ('components/footer.php');
