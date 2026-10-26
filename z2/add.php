<?php
require_once __DIR__.'/config.php';
function fail(): void { header('Location: rejestruj.php?error=1'); exit; }
$user = $_POST['user'] ?? '';
$pass = $_POST['pass'] ?? '';
$pass2 = $_POST['pass2'] ?? '';
if (!is_string($user) || !is_string($pass) || !is_string($pass2)) fail();
$user=trim($user);
if ($user==='' || mb_strlen($user)>20 || strlen($pass)<8 || $pass!==$pass2) fail();
$check=$link->prepare('SELECT id FROM users WHERE username=? LIMIT 1');
$check->bind_param('s',$user); $check->execute();
if ($check->get_result()->fetch_assoc()) fail();
$avatar='default.svg';
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
    $file=$_FILES['avatar'];
    if ($file['error']!==UPLOAD_ERR_OK || $file['size']>2097152 || $file['size']<=0) fail();
    $mime=(new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    $ext=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][$mime] ?? null;
    if (!$ext) fail();
    $name=bin2hex(random_bytes(16)).'.'.$ext;
    if (!move_uploaded_file($file['tmp_name'], __DIR__.'/uploads/'.$name)) fail();
    $avatar=$name;
}
$hash=password_hash($pass,PASSWORD_DEFAULT);
$stmt=$link->prepare('INSERT INTO users (username,password) VALUES (?,?)');
$stmt->bind_param('ss',$user,$hash);
if (!$stmt->execute()) fail();
$id=$link->insert_id;
$stmt2=$link->prepare('INSERT INTO user_avatars (user_id,filename) VALUES (?,?)');
$stmt2->bind_param('is',$id,$avatar);
$stmt2->execute();
header('Location: index.php?registered=1');
exit;
