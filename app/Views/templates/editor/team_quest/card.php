<div class="grid grid-3 body-grid jq-save">
    <div class="row-item row-item ajax-title">
        <input type="text" value="<?=$title;?>">
    </div>
    <div class="row-item row-item ajax-points">
        <input type="text" value="<?=$points;?>">
    </div>
    <div class="row-item">
        <div class="btns-control">
            <a class="btn-save ajax-update" href="#">Сохранить</a>
            <a class="btn-cancel ajax-delete" href="#">Удалить</a>
            <input type="hidden" class="result_id" value="<?=@$id;?>">
        </div>
    </div>
</div>