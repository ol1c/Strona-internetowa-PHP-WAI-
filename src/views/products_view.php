<!DOCTYPE html>
<html>

<head>
    <title>Produkty</title>
    <link rel="stylesheet" href="static/css/styles.css" />
</head>

<body>

    <table>
        <thead>
            <tr>
                <th>Nazwa</th>
                <th>Cena</th>
                <th>Operacje</th>
            </tr>
        </thead>

        <tbody>
            <?php if (count($images)): ?>
                <?php foreach ($images as $image): ?>
                    <tr>
                        <td>
                            <a href="view?id=<?= $image['_id'] ?>">
                                <?= $image['file_name'] ?>
                            </a>
                        </td>

                        <td>
                            <a href="edit?id=<?= $image['_id'] ?>">Edytuj</a> |
                            <a href="delete?id=<?= $image['_id'] ?>">Usuń</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Brak produktów</td>
                </tr>
            <?php endif ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2">Łącznie:
                    <?= count($products) ?>
                </td>
                <td>
                    <a href="edit">nowy produkt</a>
                </td>
            </tr>
        </tfoot>
    </table>

    <?php dispatch($routing, '/cart') ?>

</body>

</html>