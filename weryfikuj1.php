<?php
// UWAGA: Skrypt celowo podatny na SQL Injection.
// Tylko do ćwiczeń laboratoryjnych.

global $link;
require_once "db.php";

// Pobranie danych z formularza
$user = isset($_POST['user']) ? $_POST['user'] : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : '';

// Celowo niezabezpieczone zapytanie SQL
$sql = "SELECT * FROM users
        WHERE (username='$user')
        AND (password='$pass')";

$result = mysqli_query($link, $sql);

if (!$result) {
    die("Błąd zapytania SQL.");
}

$rekord = mysqli_fetch_assoc($result);

if (!$rekord) {
    echo "Błąd nazwy użytkownika lub hasła";
} else {
    echo "Logowanie Ok. User: "
        . htmlspecialchars($rekord['username'], ENT_QUOTES, 'UTF-8')
        . ". Hasło: "
        . htmlspecialchars($rekord['password'], ENT_QUOTES, 'UTF-8');
}

mysqli_close($link);
?>
