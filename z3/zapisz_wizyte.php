<?php
require_once __DIR__ . '/config.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['error' => 'Method not allowed']));
}

$data = json_decode(file_get_contents('php://input'), true);

if (!is_array($data)) {
    http_response_code(400);
    exit(json_encode(['error' => 'Niepoprawne dane']));
}

// Railway korzysta z reverse proxy.
// X-Forwarded-For wymaga zaufanego proxy.
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $candidate = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);

    if (filter_var($candidate, FILTER_VALIDATE_IP)) {
        $ip = $candidate;
    }
}

function field($data, $key, $max = 255) {
    $value = $data[$key] ?? '';
    if (!is_string($value)) return '';
    return substr($value, 0, $max);
}

$browser = field($data, 'browser');
$screen = field($data, 'screen', 30);
$window = field($data, 'window', 30);
$language = field($data, 'language', 50);

$colors = isset($data['colors'])
    ? (int)$data['colors'] : 0;

$cookies = !empty($data['cookies']) ? 1 : 0;

$java = !empty($data['java']) ? 1 : 0;

$stmt = $link->prepare("
    INSERT INTO goscieportalu
    (ipaddress, datetime, browser,
     screen_resolution, window_resolution,
     color_depth, cookies_enabled,
     java_enabled, language)
    VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    'ssssiiis',
    $ip,
    $browser,
    $screen,
    $window,
    $colors,
    $cookies,
    $java,
    $language
);

$stmt->execute();

echo json_encode(['success' => true]);
