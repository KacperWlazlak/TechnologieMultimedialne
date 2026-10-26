<?php
session_start();
require_once "db.php";

$user = $_POST['user'] ?? '';
$pass = $_POST['pass'] ?? '';

$stmt = mysqli_prepare(
    $link,
    "SELECT id, username, password
     FROM users
     WHERE username = ?"
);

mysqli_stmt_bind_param($stmt, "s", $user);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$rekord = mysqli_fetch_assoc($result);

if ($rekord && $rekord['password'] === $pass) {

    session_regenerate_id(true);

    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $rekord['username'];

    header("Location: index4.php");
    exit();

} else {

    echo "Nieprawidłowy login lub hasło.";
    echo '<br><a href="index3.php">Spróbuj ponownie</a>';

}

mysqli_stmt_close($stmt);
mysqli_close($link);
?>