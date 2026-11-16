<?php
require_once __DIR__ . '/config.php';

$result = $link->query("
    SELECT DATABASE() AS baza,
           @@hostname AS serwer
");

$info = $result->fetch_assoc();

echo "<h2>Połączenie PHP</h2>";
echo "Baza: " . htmlspecialchars($info['baza']);
echo "<br>";
echo "Serwer: " . htmlspecialchars($info['serwer']);

echo "<h2>Tabele widoczne dla PHP</h2>";

$result = $link->query("SHOW TABLES");

while ($row = $result->fetch_row()) {
    echo htmlspecialchars($row[0]) . "<br>";
}
?>
