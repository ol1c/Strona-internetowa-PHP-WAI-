<!DOCTYPE html>
<html>

<head>
    <title>Pokemon</title>
    <link rel="stylesheet" href="static/css/main.css" />
</head>

<body>

    <header>
        <div class="logo" id="logo-id"><a href="gallery">Pokémon</a>
        </div>
        <nav class="menu">
            <div class="menu-option"><a href="gallery">Galeria</a></div>
            <div class="menu-option"><a href="add">Dodaj zdjęcie</a></div>
            <div class="menu-option">

                <?php if (isset($model['user'])): ?>
                    <label>
                        <?= $model['user']['login'] ?>
                    </label>
                    <ul class="submenu">
                        <li><a href="logout">Wyloguj</a></li>
                    </ul>
                <?php else: ?>
                    <a href="login">Zaloguj</a>
                    <ul class="submenu">
                        <li><a href="singup">Rejestracja</a></li>
                    </ul>
                <?php endif ?>
            </div>
        </nav>
    </header>