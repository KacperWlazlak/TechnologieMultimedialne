<?php
session_start();

if (empty($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

$ip = $_SERVER['REMOTE_ADDR'] ?? '';

if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $candidate = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);

    if (filter_var($candidate, FILTER_VALIDATE_IP)) {
        $ip = $candidate;
    }
}

$details = null;

if (filter_var(
    $ip,
    FILTER_VALIDATE_IP,
    FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
)) {
    $url = 'https://ipwho.is/' . rawurlencode($ip);

    $json = @file_get_contents(
        $url,
        false,
        stream_context_create([
            'http' => ['timeout' => 3]
        ])
    );

    if ($json !== false) {
        $result = json_decode($json, true);

        if (is_array($result) && !empty($result['success'])) {
            $details = $result;
        }
    }
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LAB 3 - Geolokalizacja IP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="twoj_css.css" rel="stylesheet">
</head>

<body style="padding-top:80px">

<?php include __DIR__ . '/header.php'; ?>

<main class="container">
    <div class="card shadow-sm p-4">
        <h2>Geolokalizacja adresu IP</h2>

        <p><strong>IP:</strong> <?= e($ip) ?></p>

        <?php if ($details): ?>

            <p>Kraj: <?= e($details['country'] ?? '-') ?></p>
            <p>Region: <?= e($details['region'] ?? '-') ?></p>
            <p>Miasto: <?= e($details['city'] ?? '-') ?></p>

            <?php
            $lat = $details['latitude'] ?? null;
            $lon = $details['longitude'] ?? null;
            ?>

            <?php if (is_numeric($lat) && is_numeric($lon)): ?>
                <p>Współrzędne:
                    <?= e($lat) ?>, <?= e($lon) ?>
                </p>

                <a class="btn btn-primary"
                   target="_blank"
                   rel="noopener noreferrer"
                   href="https://www.google.com/maps/search/?api=1&amp;query=<?= rawurlencode($lat . ',' . $lon) ?>">
                    Otwórz Google Maps
                </a>
            <?php endif; ?>

        <?php else: ?>
            <div class="alert alert-warning">
                Nie udało się określić lokalizacji IP.
            </div>
        <?php endif; ?>

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
