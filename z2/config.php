<?php
// Korzysta z konfiguracji połączenia przygotowanej w laboratorium 1.
require_once __DIR__ . '/../z1/db.php';
if (!isset($link) || !($link instanceof mysqli)) {
    http_response_code(500);
    exit('Nie udało się połączyć z bazą danych.');
}
mysqli_set_charset($link, 'utf8mb4');
