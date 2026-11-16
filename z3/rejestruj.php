<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Rejestracja – Lab 3</title>

    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
    >

    <link href="twoj_css.css" rel="stylesheet">
</head>

<body>

<main class="container py-5" style="max-width: 600px">

    <div class="card shadow-sm p-4">

        <h1 class="h3">Rejestracja – LAB 3</h1>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                Nie udało się zarejestrować.
                Sprawdź login, hasła i format zdjęcia.
            </div>
        <?php endif; ?>

        <form
                action="add.php"
                method="post"
                enctype="multipart/form-data"
        >

            <label class="form-label">
                Login (maks. 20 znaków)
            </label>

            <input
                    class="form-control mb-3"
                    type="text"
                    name="user"
                    required
                    maxlength="20"
            >

            <label class="form-label">
                Hasło
            </label>

            <input
                    class="form-control mb-3"
                    type="password"
                    name="pass"
                    required
            >

            <label class="form-label">
                Powtórz hasło
            </label>

            <input
                    class="form-control mb-3"
                    type="password"
                    name="pass2"
                    required
            >

            <label class="form-label">
                Avatar (opcjonalnie JPG/PNG/WEBP)
            </label>

            <input
                    class="form-control mb-3"
                    type="file"
                    name="avatar"
                    accept="image/jpeg,image/png,image/webp"
            >

            <button type="submit" class="btn btn-success">
                Utwórz konto
            </button>

            <a class="btn btn-outline-secondary" href="index.php">
                Powrót
            </a>

        </form>

    </div>

</main>

</body>
</html>
