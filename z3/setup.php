<?php
require_once __DIR__ . '/config.php';
session_start();

if (empty($_SESSION['loggedin'])) {
    http_response_code(403);
    exit('Najpierw sie zaloguj.');
}

$columns = [
    'browser' => 'VARCHAR(255) NULL',
    'screen_resolution' => 'VARCHAR(30) NULL',
    'window_resolution' => 'VARCHAR(30) NULL',
    'color_depth' => 'INT NULL',
    'cookies_enabled' => 'TINYINT(1) NULL',
    'java_enabled' => 'TINYINT(1) NULL',
    'language' => 'VARCHAR(50) NULL'
];

$link->query("
    CREATE TABLE IF NOT EXISTS goscieportalu (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ipaddress VARCHAR(45) NOT NULL,
        datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    )
");

foreach ($columns as $name => $type) {
    $stmt = $link->prepare("
        SELECT COUNT(*) FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = 'goscieportalu'
        AND COLUMN_NAME = ?
    ");
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $stmt->bind_result($exists);
    $stmt->fetch();
    $stmt->close();

    if (!$exists) {
        $link->query("ALTER TABLE goscieportalu ADD COLUMN `$name` $type");
    }
}

echo "Gotowe! Tabela goscieportalu ma wszystkie kolumny.";
