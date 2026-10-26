LAB 2 BOOTSTRAP – instrukcja uruchomienia

1. Rozpakuj zawartość tak, aby pliki były pod /z2/ na tej samej domenie co /z1/.
2. Plik /z1/db.php musi istnieć i ustawiać połączenie MySQL w zmiennej $link.
3. W phpMyAdmin wykonaj zapytanie z pliku sql_dodatkowe.sql (baza taka sama jak w LAB1).
4. W katalogu z2/uploads musi być uprawnienie zapisu dla procesu PHP.
5. Otwórz /z2/index.php. Zaloguj user1/pass1 lub zarejestruj nowe konto.
6. W polecenieX_Y.php zmień 'Twoje nazwisko' na własne nazwisko.
7. Dodaj odnośnik <a href="z2/">Zadanie 2</a> do głównego index.php hostingu.
8. Sprawdź responsywność, 3.3, zmianę CSS, rejestrację z avatarem i bez, wylogowanie, drugi browser.

UWAGA: Nowe konta są zapisywane z hashami haseł. Starsze konta LAB1 z hasłami jawnymi są obsługiwane wyłącznie dla zgodności dydaktycznej – nie używaj prawdziwych haseł. Publiczny serwis wymaga dodatkowych zabezpieczeń (m.in. rate limiting i CSRF).
WAŻNE: header.php jest ładowany przez JS/jQuery, a sesja sprawdzana serwerowo w każdej chronionej podstronie.
Jeśli pliki PHP masz bez podkatalogu z1, zaktualizuj ścieżkę require_once w z2/config.php.
