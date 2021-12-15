<form class="grid grid-4 body-grid update-section-jury" >
    <input type="hidden" name="id" value="<?=@$id;?>">
    <div class="row-item">
        <input type="text" name="speaker" value="<?=@$speaker;?>" class="required">
    </div>
    <div class="row-item">
        <textarea class="height-100" name="youtube_iframe"><?=@$youtube_iframe;?></textarea>
    </div>
    <div class="row-item">
        <textarea class="height-100" name="text"><?=@$text;?></textarea>
    </div>
    <div class="row-item">
        <div class="btns-control">
            <button type="submit" class="btn-save btn-save-green">Сохранить</button>
            <a class="btn-cancel" href="#">Удалить</a>
        </div>
    </div>
</form>