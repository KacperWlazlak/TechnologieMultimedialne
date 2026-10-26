<?php
session_start();
if (!empty($_SESSION['loggedin'])) { header('Location: polecenie1_1.php'); exit; }
?>
<!doctype html><html lang="pl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Lab 2 – Bootstrap</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="twoj_css.css" rel="stylesheet"></head>
<body class="d-flex align-items-center min-vh-100"><main class="container" style="max-width:450px"><div class="card shadow-sm p-4"><h1 class="h3 mb-3">Lab 2 – Logowanie</h1>
<?php if (isset($_GET['error'])): ?><div class="alert alert-danger">Niepoprawny login lub hasło.</div><?php endif; ?>
<?php if (isset($_GET['registered'])): ?><div class="alert alert-success">Konto utworzone. Zaloguj się.</div><?php endif; ?>
<form action="weryfikuj.php" method="post"><label class="form-label" for="user">Login</label><input required class="form-control mb-3" id="user" name="user" maxlength="20" autocomplete="username"><label class="form-label" for="pass">Hasło</label><input required class="form-control mb-3" type="password" id="pass" name="pass" autocomplete="current-password"><button class="btn btn-primary w-100">Zaloguj</button></form>
<a class="mt-3 d-block" href="rejestruj.php">Zarejestruj konto</a></div></main></body></html>
