<?php
    require_once('database/db_connection.php');
    require 'views/components/header.php';
?>

<h1>News</h1>

<?php
$sql = "SELECT news.id, news.created, news.title, news.main_text, users.username FROM news JOIN users ON news.user_id == users.id ORDER BY news.created DESC";
$responce = $db->query($sql);
while ($result = $responce->fetchArray(SQLITE3_ASSOC)) {
    echo "
    <div class='container'>
        <div class='news'>
            <div class='row'>
                <h2>{$result['title']}</h2>
            </div>
            <div class='row text-center p-1'>
                <p>Posted by {$result['username']} at {$result['created']}</p>
            </div>
            <div class='row'>
                <p>" . substr($result['main_text'], 0, 230) . "...</p>
            </div>
            <div class='row'>
                <p>
                    <a class='btn btn-secondary' href='/views/news.php?id={$result['id']}'>
                        News Page
                    </a>
                </p>
                <h2></h2>
            </div>
        </div>
    </div>
    ";
}
?>

<?php require 'views/components/footer.php';
