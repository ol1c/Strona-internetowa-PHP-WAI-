<main>

    <div class="prev-next"><a href="gallery">Wróć</a></div>

    <div class="gallery">
        <div class="gallery-one">
            <div class="gallery-text">

                <h1>
                    "
                    <?= $image['title'] ?>
                    "
                </h1>

                <span>Autor:
                    <?= $image['author'] ?>
                </span>
            </div>

            <img src="img/zw/<?= pathinfo($image['file_name'], PATHINFO_FILENAME) ?>.png" alt="<?= $image['title'] ?>"
                class="gallery-image" />
        </div>
    </div>

</main>