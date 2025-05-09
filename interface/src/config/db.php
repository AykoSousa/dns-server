<?php

Flight::register('db', 'PDO', ['sqlite:/home/ayko_nascimento/dns-server/db/dns.db'], function($db) {
    if (!$db) {
        throw new Exception('Could not connect to the database');
    }

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id TEXT PRIMARY KEY,
        username TEXT NOT NULL,
        email TEXT NOT NULL,
        password TEXT NOT NULL
    )");
});