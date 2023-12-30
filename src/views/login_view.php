<main>
    <div id="blad">
        <?php if (isset($model['blad'])) {
            echo $model['blad'];
        } ?>
    </div>
    <form method="post">
        <fieldset>
            <legend>Zaloguj się: </legend>
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" required />
            <label for="password">Hasło:</label>
            <input type="password" name="password" id="password" required />
        </fieldset>
        <div class="buttons">
            <button type="submit">Zaloguj</button>
        </div>
    </form>
</main>