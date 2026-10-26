<?php declare(strict_types=1); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top"><div class="container-fluid"><a class="navbar-brand" href="polecenie1_1.php">LAB 2</a><button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav" aria-controls="main_nav" aria-expanded="false" aria-label="Rozwiń menu"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="main_nav"><ul class="navbar-nav me-auto mb-2 mb-lg-0">
<?php for($g=1;$g<=3;$g++): ?><li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Polecenia <?= $g ?>.x</a><ul class="dropdown-menu">
<?php for($n=1;$n<=($g===3?3:2);$n++): ?><li><a class="dropdown-item" href="polecenie<?= $g ?>_<?= $n ?>.php">Polecenie <?= $g ?>.<?= $n ?></a></li><?php endfor; ?></ul></li><?php endfor; ?>
</ul><a class="btn btn-outline-light btn-sm" href="logout.php">↪ Wyloguj</a></div></div></nav>
