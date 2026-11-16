<?php
session_start();

if (empty($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

function esc($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function command_output($cmd) {
    if (!function_exists('shell_exec')) {
        return 'Polecenie zablokowane na hostingu.';
    }

    $output = @shell_exec($cmd . ' 2>&1');

    return $output ?: 'Brak wyniku lub polecenie niedostepne.';
}

$page = $page ?? '';

$titles = [
    'netstat' => 'Netstat - połączenia sieciowe',
    'phpinfo' => 'PHP Info',
    'whoami' => 'Whoami - użytkownik serwera',
    'top' => 'TOP - procesy serwera',
    'ls' => 'Lista plików i uprawnienia',
    'dns' => 'Rekordy DNS',
    'hosts' => 'Adresy IP i nazwy hostów'
];

if (!isset($titles[$page])) {
    http_response_code(404);
    exit('Nieznane polecenie.');
}

if ($page === 'phpinfo') {
    phpinfo();
    exit;
}

$output = '';

switch ($page) {
    case 'netstat':
        $output = command_output(
            'command -v netstat >/dev/null && netstat -tuln || ss -tuln'
        );
        break;

    case 'whoami':
        $output = command_output('whoami');
        break;

    case 'top':
        $output = command_output('top -b -n 1');
        break;

    case 'ls':
        $output = command_output('ls -al');
        break;

    case 'dns':
        $output = print_r(
            dns_get_record('pbs.edu.pl'),
            true
        );
        break;

    case 'hosts':
        $domain = 'pbs.edu.pl';
        $visitorIp = $_SERVER['REMOTE_ADDR'] ?? '';

        $output =
            "Domena: " . $domain . "\n" .
            "IP domeny: " . gethostbyname($domain) . "\n" .
            "IP goscia (REMOTE_ADDR): " . $visitorIp . "\n" .
            "Host 8.8.8.8: " . gethostbyaddr('8.8.8.8') . "\n" .
            "Host goscia: " .
            ($visitorIp ? gethostbyaddr($visitorIp) : 'Brak');
        break;
}
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title><?= esc($titles[$page]) ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="twoj_css.css" rel="stylesheet">
</head>

<body style="padding-top:80px">

<?php include __DIR__ . '/header.php'; ?>

<main class="container">

    <div class="card shadow-sm p-4">

        <h2><?= esc($titles[$page]) ?></h2>

        <p class="text-muted">
            Wynik uruchomienia polecenia na serwerze Railway.
        </p>

        <pre class="bg-light p-3 border rounded"
             style="white-space:pre-wrap;overflow:auto"><?= esc($output) ?></pre>

        <a href="goscie.php" class="btn btn-primary">
            Historia wizyt
        </a>

    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
