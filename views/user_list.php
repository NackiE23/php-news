<?php
    require_once('../database/db_connection.php');
    require 'components/header.php';

    if (!$_SESSION['user']['is_admin']) {
        header('Location: /');
        exit();
    }
?>

<h1>Users</h1>

<div class="container">
    <ul class="list-group list-group-flush mb-4">
        <?php
            $sql = "SELECT * FROM users ORDER BY users.username";
            $users = $db->query($sql);
            while ($user = $users->fetchArray(SQLITE3_ASSOC)) {
                echo "
                <li class='list-group-item bg-dark border-secondary text-light mb-2 d-flex justify-content-center align-items-center'>
                        {$user['username']}: {$user['email']}
                        <form action='../services/delete_user.php' method='POST'>
                            <input type='hidden' name='user_id' value={$user['id']}>
                            <button class='btn btn-danger ms-2' type='submit'>Delete</button>
                        </form>
                </li>";
            }
        ?>
    </ul>
</div>

<?php require 'components/footer.php';
