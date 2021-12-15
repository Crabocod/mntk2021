<div class="grid grid-4 body-grid jq-save">
    <div class="row-item ajax-name">
        <input type="text" value="<?=$name;?>">
    </div>
    <div class="row-item ajax-surname">
        <input type="text" value="<?=$surname;?>">
    </div>
    <div class="row-item ajax-email">
        <input type="text" value="<?=$email;?>">
    </div>
    <div class="row-item">
        <div class="btns-control">
            <a class="btn-save ajax-update" href="#">Сохранить</a>
            <a class="btn-cancel ajax-delete" href="#">Удалить</a>
            <a class="send-pass <?=(@$pass_send == 1)?'hover':'';?>" href="#"></a>
            <input type="hidden" class="user_id" value="<?=@$id;?>">
        </div>
    </div>
</div>