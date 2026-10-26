<?php
require_once __DIR__.'/auth.php';
require_once __DIR__.'/config.php';
$avatar='default.svg';
$id=(int)($_SESSION['user_id'] ?? 0);
$stmt=$link->prepare('SELECT filename FROM user_avatars WHERE user_id=? LIMIT 1');
$stmt->bind_param('i',$id); $stmt->execute();
$row=$stmt->get_result()->fetch_assoc();
if ($row && $row['filename']) $avatar=basename($row['filename']);
$who=htmlspecialchars((string)($_SESSION['username'] ?? ''),ENT_QUOTES,'UTF-8');
?>
<!doctype html><html lang="pl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Twoje nazwisko – Zadanie 2</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="twoj_css.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script><script src="twoj_js.js"></script></head>
<body onload="myLoadHeader()"><div id="myHeader"></div><main class="container sekcja1"><div class="card shadow-sm p-4"><div class="d-flex align-items-center gap-3 mb-3"><img class="avatar" alt="Avatar" src="uploads/<?= rawurlencode($avatar) ?>"><div><small>Zalogowany: <?= $who ?></small><h1 class="h3 mb-0">Polecenie 1.2</h1></div></div><p>Wybrano opcję Polecenie 1.2 z menu Bootstrap.</p></div></main><?php require 'footer.php'; ?></body></html>
