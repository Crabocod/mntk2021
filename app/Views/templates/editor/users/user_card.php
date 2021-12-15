<div class="grid grid-5 body-grid jq-save">
    <div class="row-item ajax-name">
        <input type="text" value="<?=esc($name);?>">
    </div>
    <div class="row-item ajax-surname">
        <input type="text" value="<?=esc($surname);?>">
    </div>
    <div class="row-item ajax-email">
        <input type="text" value="<?=esc($email);?>">
    </div>
    <div class="row-item ajax-og">
        <input type="text" value="<?=esc(@$og_title);?>">
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