<form class="grid grid-5 body-grid" conference_id="<?=@$id;?>">
    <div class="row-item">
        <textarea rows="4" name="title"><?=@esc($title);?></textarea>
    </div>
    <div class="row-item">
        <textarea rows="4" name="title_head"><?=@esc($title_head);?></textarea>
    </div>
    <div class="row-item">
        <span class="-flex -center"> /</span><input type="text" value="<?=@$url_segment;?>" name="url_segment">
    </div>
    <div class="row-item row-2-items">
        <input type="text" value="<?=@$eventicious_api_key;?>" name="eventicious_api_key">
        <span onclick="copytext($(this))" url="<?=base_url().'/eventicious-sync/'.@$id.'/user/';?>">Скопировать ссылку для интеграции</span>
    </div>
    <div class="row-item">
        <div class="btns-control">
            <button class="btn-save js-conference-save" href="#">Сохранить</button>
            <a class="btn-cancel js-conference-delete" href="#">Удалить</a>
        </div>
    </div>
</form>