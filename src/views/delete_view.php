<form method="post">
    Czy usunąć produkt:
    <?= $user['login'] ?>?

    <input type="hidden" name="id" value="<?= $user['_id'] ?>">

    <div>
        <a href="products" class="cancel">Anuluj</a>
        <input type="submit" value="Potwierdź" />
    </div>
</form>