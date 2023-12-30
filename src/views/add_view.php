<main>
    <form method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Dane:</legend>
            <label for="author">Autor:</label>
            <input type="text" name="author" id="author"
                value="<?php if (isset($model['user'])): ?><?= $model['user']['login'] ?><?php endif ?>" required>
            <label for="title">Tytuł:</label>
            <input type="text" name="title" id="title" required>
            <label>Załącz plik:<input type="file" name="file" id="file" accept=".jpg, .jpeg, .png" required></label>
            <label for="watermark">Znak wodny:</label>
            <input type="text" name="watermark" id="watermark"
                value="<?php if (isset($model['user'])): ?><?= $model['user']['login'] ?><?php endif ?>" required>
            <input type="hidden" name="id">
        </fieldset>
        <div class="buttons">
            <button type="submit">Wyśli</button>
            <button type="reset">Wyczyść</button>
        </div>
    </form>
</main>