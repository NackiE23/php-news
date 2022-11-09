<?php
    class DB extends SQLite3 {
        function __construct($file) {
            $this->open($file);
        }
    }

    $db = new DB(__DIR__ . '/database.db');

    if (!$db) {
        die('Error: cannot open the database!');
    }
