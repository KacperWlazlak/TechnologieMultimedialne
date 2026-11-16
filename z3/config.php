<?php
// LAB 3 - polaczenie z osobna baza MySQL na Railway

$host = getenv('Z3_DB_HOST');
$port = getenv('Z3_DB_PORT') ?: '3306';
$dbname = getenv('Z3_DB_NAME');
$user = getenv('Z3_DB_USER');
$password = getenv('Z3_DB_PASSWORD');

if (!$host || !$dbname || !$user || $password === false) {
    error_log('Brak konfiguracji bazy danych LAB 3.');
    exit('Blad konfiguracji bazy danych.');
}

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $link = new mysqli(
        $host,
        $user,
        $password,
        $dbname,
        (int)$port
    );

    $link->set_charset('utf8mb4');

} catch (mysqli_sql_exception $e) {
    error_log('LAB 3 MySQL: ' . $e->getMessage());
    exit('Blad polaczenia z baza danych.');
}
?>
