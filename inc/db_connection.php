<?php

    $db = new SQLite3(__DIR__ . '/../database/database.db');

    if (!$db) {
        die('Error: cannot open the database!');
    }
    
