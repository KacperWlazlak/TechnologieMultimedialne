<?php
session_start();
require_once __DIR__ . '/config.php';
$user = $_POST['user'] ?? '';
$pass = $_POST['pass'] ?? '';
if (!is_string($user) || !is_string($pass)) { header('Location: index.php?error=1'); exit; }
$stmt = $link->prepare('SELECT id, username, password FROM users WHERE username = ? LIMIT 1');
$stmt->bind_param('s', $user);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
// Obsługa starszych kont z LAB1 (hasła jawne) i nowych haseł haszowanych.
$ok = $row && (password_verify($pass, $row['password']) || hash_equals($row['password'], $pass));
if (!$ok) { header('Location: index.php?error=1'); exit; }
session_regenerate_id(true);
$_SESSION['loggedin'] = true;
$_SESSION['username'] = $row['username'];
$_SESSION['user_id'] = (int)$row['id'];
header('Location: polecenie1_1.php');
exit;
