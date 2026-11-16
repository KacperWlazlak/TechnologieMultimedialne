<?php declare(strict_types=1); ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">

        <a class="navbar-brand" href="polecenie1_1.php">
            LAB 3
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#main_nav"
                aria-controls="main_nav"
                aria-expanded="false"
                aria-label="Rozwiń menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="main_nav">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#"
                       data-bs-toggle="dropdown">
                        Serwer PHP
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="polecenie1_1.php">Netstat</a></li>
                        <li><a class="dropdown-item" href="polecenie1_2.php">PHP Info</a></li>
                        <li><a class="dropdown-item" href="polecenie2_1.php">Whoami</a></li>
                        <li><a class="dropdown-item" href="polecenie2_2.php">TOP - procesy</a></li>
                        <li><a class="dropdown-item" href="polecenie3_1.php">Lista plików</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#"
                       data-bs-toggle="dropdown">
                        DNS i Geolokalizacja
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="polecenie3_2.php">Rekordy DNS</a></li>
                        <li><a class="dropdown-item" href="polecenie3_3.php">Adresy IP i hosty</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="geolokalizacja.php">
                        Geolokalizacja IP
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="goscie.php">
                        Historia wizyt
                    </a>
                </li>

            </ul>

            <a class="btn btn-outline-light btn-sm" href="logout.php">
                ↪ Wyloguj
            </a>

        </div>
    </div>
</nav>
