<?php
require_once __DIR__ . '/config.php';

$link->query("
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(20) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )
");

$link->query("
    CREATE TABLE IF NOT EXISTS goscieportalu (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ipaddress VARCHAR(45) NOT NULL,
        datetime DATETIME NOT NULL
            DEFAULT CURRENT_TIMESTAMP
    )
");

echo "Tabele zostaly utworzone!";
?>
