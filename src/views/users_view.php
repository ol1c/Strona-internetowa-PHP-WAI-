<main>

    <table>


        <tbody>
            <?php if (count($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <?= $user['login'] ?>
                        </td>
                        <td>
                            <?= $user['password'] ?>
                        </td>
                        <td><a href="delete?id=<?= $user['_id'] ?>">Usuń</a>
                        </td>

                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Brak produktów</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</main>