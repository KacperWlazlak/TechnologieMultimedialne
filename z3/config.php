<?php
$host = getenv('Z3_DB_HOST');
$port = getenv('Z3_DB_PORT') ?: 3306;
$dbname = getenv('Z3_DB_NAME');
$user = getenv('Z3_DB_USER');
$password = getenv('Z3_DB_PASSWORD');

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    error_log($e->getMessage());
    exit("Błąd połączenia z bazą danych.");
}
?>
