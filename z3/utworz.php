<?php
require_once __DIR__ . '/config.php';

try {
    $link->query("
        CREATE TABLE IF NOT EXISTS user_avatars (
            user_id INT NOT NULL,
            filename VARCHAR(100) NOT NULL DEFAULT 'default.svg',
            PRIMARY KEY (user_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");

    echo "Tabela user_avatars zostala utworzona!";

} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    echo "Blad podczas tworzenia tabeli.";
}
?>
