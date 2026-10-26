<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
</head>
<body>

<h2>Rejestracja nowego użytkownika</h2>

<form action="add.php" method="post">

    Login:
    <input
        type="text"
        name="user"
        maxlength="20"
        required
    >
    <br><br>

    Hasło:
    <input
        type="password"
        name="pass"
        required
    >
    <br><br>

    Powtórz hasło:
    <input
        type="password"
        name="pass2"
        required
    >
    <br><br>

    <input type="submit" value="Zarejestruj">

</form>

<p>
    <a href="index3.php">Powrót do logowania</a>
</p>

</body>
</html>