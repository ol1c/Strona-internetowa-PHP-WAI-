<main>
    <div id="blad">
        <?php if (isset($model['blad'])) {
            echo $model['blad'];
        } ?>
    </div>
    <div class="gallery" id="galeria">
        <?php echo $model['display'] ?>
    </div>
</main>