<?php
require_once "db.php";

$user = trim($_POST['user'] ?? '');
$pass = $_POST['pass'] ?? '';
$pass2 = $_POST['pass2'] ?? '';

if ($user === '' || $pass === '' || $pass2 === '') {
    die("Wypełnij wszystkie pola.");
}

if (strlen($user) > 20) {
    die("Login jest za długi.");
}

if ($pass !== $pass2) {
    die(
    'Hasła nie są identyczne.<br>
        <a href="rejestruj.php">Wróć</a>'
    );
}

// Sprawdzenie, czy login już istnieje
$stmt = mysqli_prepare(
    $link,
    "SELECT id FROM users WHERE username = ?"
);

mysqli_stmt_bind_param($stmt, "s", $user);
mysqli_stmt_execute($stmt);

mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    mysqli_stmt_close($stmt);
    mysqli_close($link);

    die(
    'Taki użytkownik już istnieje.<br>
        <a href="rejestruj.php">Wróć</a>'
    );
}

mysqli_stmt_close($stmt);

// Dodawanie nowego użytkownika
$stmt = mysqli_prepare(
    $link,
    "INSERT INTO users (username, password)
     VALUES (?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $user,
    $pass
);

if (mysqli_stmt_execute($stmt)) {

    echo "Rejestracja zakończona pomyślnie!";
    echo '<br><a href="index3.php">Zaloguj się</a>';

} else {

    echo "Błąd podczas rejestracji.";

}

mysqli_stmt_close($stmt);
mysqli_close($link);
?>