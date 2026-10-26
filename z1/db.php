<?php

$host = getenv("MYSQLHOST");
$port = (int) getenv("MYSQLPORT");
$db_user = getenv("MYSQLUSER");
$db_pass = getenv("MYSQLPASSWORD");
$db_name = "z1_";

$link = mysqli_connect(
    $host,
    $db_user,
    $db_pass,
    $db_name,
    $port
);

if (!$link) {
    die("Błąd połączenia z bazą danych");
}

mysqli_set_charset($link, "utf8mb4");

?>
