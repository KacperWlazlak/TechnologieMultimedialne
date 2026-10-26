<?php
session_start();

if (
    !isset($_SESSION['loggedin']) ||
    $_SESSION['loggedin'] !== true
) {
    header("Location: index3.php");
    exit();
}

$username = htmlspecialchars(
    $_SESSION['username'] ?? '',
    ENT_QUOTES,
    'UTF-8'
);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel użytkownika</title>
</head>
<body>

<h2>Panel użytkownika</h2>

<p>Jestem zalogowany!</p>

<p>Witaj, <?php echo $username; ?>!</p>

<a href="logout.php">Wyloguj się</a>

</body>
</html>