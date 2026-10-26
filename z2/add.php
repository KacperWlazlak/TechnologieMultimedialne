
<?php

require_once __DIR__ . '/config.php';

// Funkcja obsługi błędów rejestracji
function fail(): void {
    header('Location: rejestruj.php?error=1');
    exit;
}

// Pobranie danych z formularza
$user = $_POST['user'] ?? '';
$pass = $_POST['pass'] ?? '';
$pass2 = $_POST['pass2'] ?? '';

// Sprawdzenie typów danych
if (
    !is_string($user) ||
    !is_string($pass) ||
    !is_string($pass2)
) {
    fail();
}

$user = trim($user);

// Walidacja danych bez limitu minimum 8 znaków
if (
    $user === '' ||
    mb_strlen($user) > 20 ||
    $pass === '' ||
    $pass !== $pass2
) {
    fail();
}

// Sprawdzenie, czy użytkownik istnieje
$check = $link->prepare(
    'SELECT id FROM users WHERE username = ? LIMIT 1'
);

$check->bind_param('s', $user);
$check->execute();

if ($check->get_result()->fetch_assoc()) {
    fail();
}

$check->close();

// Domyślny avatar
$avatar = 'default.svg';

// Obsługa przesłanego avataru
if (
    isset($_FILES['avatar']) &&
    $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE
) {

    $file = $_FILES['avatar'];

    if (
        $file['error'] !== UPLOAD_ERR_OK ||
        $file['size'] > 2097152 ||
        $file['size'] <= 0
    ) {
        fail();
    }

    // Sprawdzenie typu pliku
    $mime = (new finfo(FILEINFO_MIME_TYPE))
        ->file($file['tmp_name']);

    $ext = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp'
    ][$mime] ?? null;

    if (!$ext) {
        fail();
    }

    // Losowa nazwa pliku
    $name = bin2hex(random_bytes(16)) . '.' . $ext;

    // Zapis avataru
    if (!move_uploaded_file(
        $file['tmp_name'],
        __DIR__ . '/uploads/' . $name
    )) {
        fail();
    }

    $avatar = $name;
}

// Haszowanie hasła
$hash = password_hash($pass, PASSWORD_DEFAULT);

// Dodanie użytkownika do bazy
$stmt = $link->prepare(
    'INSERT INTO users (username, password)
     VALUES (?, ?)'
);

$stmt->bind_param('ss', $user, $hash);

if (!$stmt->execute()) {
    fail();
}

// Pobranie ID nowego użytkownika
$id = $link->insert_id;

// Zapis informacji o avatarze
$stmt2 = $link->prepare(
    'INSERT INTO user_avatars (user_id, filename)
     VALUES (?, ?)'
);

$stmt2->bind_param('is', $id, $avatar);
$stmt2->execute();

// Przekierowanie po rejestracji
header('Location: index.php?registered=1');
exit;
