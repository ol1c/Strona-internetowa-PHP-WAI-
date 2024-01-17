<main>
    <div id="blad">
        <?php if (isset($model['blad'])) {
            echo $model['blad'];
        } ?>
    </div>
    <div class="gallery" id="galeria">
        <?php if (isset($display['images'])): ?>
            <?php for ($i = 1; $i <= count($display['images']); $i++): ?>
                <div class="gallery-item">
                    <a href=" <?= 'image?id=' . $display['images'][$i]['_id'] ?>">
                        <img src=" <?= 'img/miniaturki/' . pathinfo($display['images'][$i]['file_name'], PATHINFO_FILENAME) . '.png' ?>"
                            alt=" <?= pathinfo($display['images'][$i]['file_name'], PATHINFO_FILENAME) ?>" class="gallery-img">
                    </a>
                    <div class="gallery-text">
                        <h3>
                            <?= $display['images'][$i]['title'] ?>
                        </h3>
                        <?= $display['images'][$i]['author'] ?>
                    </div>
                </div>
            <?php endfor ?>
        <?php else: ?>
            Nie ma niczego
        <?php endif ?>
    </div>
    <div class="prev-next">
        <?php
        if (isset($display['prev'])) {
            echo '<a href="?page=' . $display['prev'] . '">Poprzednia</a>';
        }
        if (isset($display['next'])) {
            echo '<a href="?page=' . $display['next'] . '">Następna</a>';
        }
        ?>
    </div>
</main>