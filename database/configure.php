<?php

class DB extends SQLite3 {
    function __construct($file) {
        $this->open($file);
    }
}

$db = new DB('database.db');

# Create database
$db->exec("
  CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY autoincrement,
    email TEXT UNIQUE NOT NULL,
    username TEXT NOT NULL,
    password TEXT NOT NULL,
    is_admin BOOLEAN NOT NULL DEFAULT 0 CHECK (is_admin IN (0, 1))
  );
  CREATE TABLE IF NOT EXISTS news (
    id INTEGER PRIMARY KEY autoincrement,
    created DATETIME,
    title TEXT NOT NULL,
    main_text TEXT NOT NULL,
    user_id INTEGER NOT NULL,
    FOREIGN KEY(user_id) REFERENCES users(id)
  );
  CREATE TABLE IF NOT EXISTS comments (
    id INTEGER PRIMARY KEY autoincrement,
    main_text TEXT NOT NULL,
    news_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(news_id) REFERENCES news(id)
  );
");

$current_datetime = date('Y-m-d H:i');
$admin_password = password_hash('admin', PASSWORD_DEFAULT);
# Insert information to database
$db->exec("
  INSERT INTO users (email, username, password)
  VALUES
    ('test1@gmail.com', 'NackiE23', 'NackiE23'),
    ('test2@gmail.com', 'NackiE24', 'NackiE24'),
    ('test3@gmail.com', 'NackiE25', 'NackiE25'),
    ('test4@gmail.com', 'NackiE26', 'NackiE26'),
    ('test5@gmail.com', 'NackiE27', 'NackiE27');
  INSERT INTO users (email, username, password, is_admin)
  VALUES
      ('admin@admin.net', 'admin', '$admin_password', 1);
  INSERT INTO news (created, title, main_text, user_id)
  VALUES
    ('$current_datetime', 'Gnome will kill yourself!', 'It is very dangerous', 1),
    ('$current_datetime', 'Gnome killed me!', 'Finaly I am free!', 1);
  INSERT INTO comments (main_text, news_id, user_id) VALUES ('Gnome is superior', 2, 4);
");

// # SELECT news from database
$sql = "
SELECT news.title, news.main_text, users.username
FROM news
JOIN users
    ON news.user_id == users.id
ORDER BY news.title ASC
";
