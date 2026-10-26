<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
</head>
<body>

<h2>Logowanie do aplikacji</h2>

<form action="weryfikuj3.php" method="post">
    Login:
    <input type="text" name="user" required>
    <br><br>

    Hasło:
    <input type="password" name="pass" required>
    <br><br>

    <input type="submit" value="Zaloguj">
</form>

<p>
    <a href="rejestruj.php">Zarejestruj konto</a>
</p>

</body>
</html>