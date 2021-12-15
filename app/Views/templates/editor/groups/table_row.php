<form class="grid grid-2 body-grid update-group">
    <input type="hidden" name="id" value="<?= @$id; ?>">
    <div class="row-item row-item">
        <input name="title" type="text" value="<?= @$title; ?>" class="required">
    </div>
    <div class="row-item">
        <div class="btns-control">
            <button class="btn-save">Сохранить</button>
            <a class="btn-cancel" href="#">Удалить</a>
        </div>
    </div>
</form>