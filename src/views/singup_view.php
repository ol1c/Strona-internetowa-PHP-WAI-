<main>
    <div id="blad">
        <?php if (isset($model['blad'])) {
            echo $model['blad'];
        } ?>
    </div>
    <form method="post">
        <fieldset>
            <legend>Rejestracja: </legend>
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" required />
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required />
            <label for="password">Hasło:</label>
            <input type="password" name="password" id="password" required />
            <label for="password2">Powtórz hasło:</label>
            <input type="password" name="password2" id="password2" required />
            <input type="hidden" name="id">
        </fieldset>
        <div class="buttons">
            <button type="submit">Zaloguj</button>
        </div>
    </form>
</main>