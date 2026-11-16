<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function fail(): never {
    header('Location: rejestruj.php?error=1');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fail();
}

$user = $_POST['user'] ?? '';
$pass = $_POST['pass'] ?? '';
$pass2 = $_POST['pass2'] ?? '';

if (
    !is_string($user) ||
    !is_string($pass) ||
    !is_string($pass2)
) {
    fail();
}

$user = trim($user);

if (
    $user === '' ||
    mb_strlen($user) > 20 ||
    $pass === '' ||
    $pass !== $pass2
) {
    fail();
}

// Sprawdzenie, czy login jest zajęty
$check = $link->prepare(
    'SELECT id FROM users WHERE username = ? LIMIT 1'
);

$check->bind_param('s', $user);
$check->execute();

if ($check->get_result()->fetch_assoc()) {
    $check->close();
    fail();
}

$check->close();

// Domyślny avatar
$avatar = 'default.svg';
$uploadedPath = null;

// Obsługa zdjęcia profilowego
if (
    isset($_FILES['avatar']) &&
    $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE
) {
    $file = $_FILES['avatar'];

    if (
        $file['error'] !== UPLOAD_ERR_OK ||
        $file['size'] <= 0 ||
        !is_uploaded_file($file['tmp_name'])
    ) {
        fail();
    }

    // Akceptowane formaty
    $mime = (new finfo(FILEINFO_MIME_TYPE))
        ->file($file['tmp_name']);

    $extensions = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp'
    ];

    $ext = $extensions[$mime] ?? null;

    if ($ext === null) {
        fail();
    }

    // Trwały katalog na Railway Volume
    $uploadDir = '/data/avatars/';

    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
            error_log('Nie mozna utworzyc katalogu avatarow.');
            fail();
        }
    }

    if (!is_writable($uploadDir)) {
        error_log('Brak uprawnien zapisu: ' . $uploadDir);
        fail();
    }

    // Unikalna nazwa zdjęcia
    $avatar = bin2hex(random_bytes(16)) . '.' . $ext;
    $uploadedPath = $uploadDir . $avatar;

    // Zapis pliku bez wyswietlania warningow
    if (!@move_uploaded_file(
        $file['tmp_name'],
        $uploadedPath
    )) {
        error_log('Nie udalo sie zapisac avatara.');
        fail();
    }
}

// Haszowanie hasła
$hash = password_hash($pass, PASSWORD_DEFAULT);

try {
    $link->begin_transaction();

    // Dodanie użytkownika
    $stmt = $link->prepare(
        'INSERT INTO users (username, password)
         VALUES (?, ?)'
    );

    $stmt->bind_param('ss', $user, $hash);
    $stmt->execute();

    $id = $link->insert_id;
    $stmt->close();

    // Zapis avatara w bazie
    $stmt2 = $link->prepare(
        'INSERT INTO user_avatars (user_id, filename)
         VALUES (?, ?)'
    );

    $stmt2->bind_param('is', $id, $avatar);
    $stmt2->execute();
    $stmt2->close();

    $link->commit();

    header('Location: index.php?registered=1');
    exit;

} catch (Throwable $e) {
    $link->rollback();

    if ($uploadedPath !== null && is_file($uploadedPath)) {
        @unlink($uploadedPath);
    }

    error_log('Blad rejestracji: ' . $e->getMessage());

    fail();
}
