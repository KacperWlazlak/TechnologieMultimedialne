<?php
session_start();

if (empty($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/config.php';

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function geo($ip) {
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        return null;
    }

    if (!filter_var(
        $ip,
        FILTER_VALIDATE_IP,
        FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
    )) {
        return null;
    }

    if (!isset($_SESSION['geo_cache'])) {
        $_SESSION['geo_cache'] = [];
    }

    if (isset($_SESSION['geo_cache'][$ip])) {
        return $_SESSION['geo_cache'][$ip];
    }

    // Maksymalnie 5 nowych zapytan na wyswietlenie strony
    global $geo_requests;

    if ($geo_requests >= 5) {
        return null;
    }

    $geo_requests++;

    $url = 'https://ipwho.is/' . rawurlencode($ip);

    $context = stream_context_create([
        'http' => [
            'timeout' => 2,
            'ignore_errors' => true
        ]
    ]);

    $json = @file_get_contents($url, false, $context);

    if ($json === false) {
        return null;
    }

    $data = json_decode($json, true);

    if (!is_array($data) || empty($data['success'])) {
        return null;
    }

    $_SESSION['geo_cache'][$ip] = $data;

    return $data;
}

$geo_requests = 0;

$result = $link->query("
    SELECT *
    FROM goscieportalu
    ORDER BY datetime DESC, id DESC
    LIMIT 500
");

$rows = $result->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>LAB 3 - Goście portalu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.2/dist/bootstrap-table.min.css"
          rel="stylesheet">

    <link href="twoj_css.css" rel="stylesheet">
</head>

<body style="padding-top:80px">

<?php include __DIR__ . '/header.php'; ?>

<main class="container-fluid px-4">

    <h2 class="mb-3">LAB 3 - Historia wizyt gości portalu</h2>

    <p>Wszystkie informacje o odwiedzających portal.</p>

    <div class="table-responsive">

        <table id="tabela"
               class="table table-striped table-bordered table-hover"
               data-search="true"
               data-pagination="true"
               data-page-size="10"
               data-page-list="[10,25,50,100]"
               data-sortable="true">

            <thead class="table-dark">
            <tr>
                <th data-field="date" data-sortable="true">Data</th>
                <th data-field="ip" data-sortable="true">IP</th>
                <th data-field="location" data-sortable="true">Lokalizacja</th>
                <th>Współrzędne</th>
                <th>Google Maps</th>
                <th data-field="browser" data-sortable="true">Przeglądarka</th>
                <th>Rozdzielczość ekranu</th>
                <th>Rozdzielczość okna</th>
                <th>Kolory</th>
                <th>Cookies</th>
                <th>Java</th>
                <th data-field="language" data-sortable="true">Język</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($rows as $row): ?>

                <?php
                $details = geo($row['ipaddress']);

                $location = 'Brak danych';
                $coordinates = '-';
                $map = '-';

                if ($details) {
                    $location = implode(', ', array_filter([
                        $details['country'] ?? '',
                        $details['region'] ?? '',
                        $details['city'] ?? ''
                    ]));

                    $lat = $details['latitude'] ?? null;
                    $lon = $details['longitude'] ?? null;

                    if (is_numeric($lat) && is_numeric($lon)) {
                        $coordinates = $lat . ',' . $lon;

                        $url = 'https://www.google.com/maps/search/?api=1&query='
                            . rawurlencode($coordinates);

                        $map = '<a href="' . e($url) .
                            '" target="_blank" rel="noopener noreferrer">Mapa</a>';
                    }
                }
                ?>

                <tr>
                    <td><?= e($row['datetime']) ?></td>
                    <td><?= e($row['ipaddress']) ?></td>
                    <td><?= e($location) ?></td>
                    <td><?= e($coordinates) ?></td>
                    <td><?= $map ?></td>
                    <td><?= e($row['browser'] ?? '-') ?></td>
                    <td><?= e($row['screen_resolution'] ?? '-') ?></td>
                    <td><?= e($row['window_resolution'] ?? '-') ?></td>
                    <td><?= e($row['color_depth'] ?? '-') ?></td>

                    <td>
                        <?= isset($row['cookies_enabled'])
                            ? ($row['cookies_enabled'] ? 'Tak' : 'Nie')
                            : '-' ?>
                    </td>

                    <td>
                        <?= isset($row['java_enabled'])
                            ? ($row['java_enabled'] ? 'Tak' : 'Nie')
                            : '-' ?>
                    </td>

                    <td><?= e($row['language'] ?? '-') ?></td>
                </tr>

            <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.2/dist/bootstrap-table.min.js"></script>

<script>
    $(function () {
        $('#tabela').bootstrapTable();
    });
</script>

</body>
</html>
