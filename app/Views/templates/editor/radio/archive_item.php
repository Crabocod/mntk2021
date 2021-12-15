<form class="grid grid-6 body-grid shahmatka-grid-6" id="update-archive">
    <input type="hidden" name="id" value="<?=$id;?>">
    <div class="row-item">
        <input name="date" type="text" value="<?=$date;?>" class="litepicker-date required" placeholder="дд.мм.гггг" autocomplete="off">
    </div>
    <div class="row-item">
        <input name="title" type="text" value="<?=$title;?>" class="required">
    </div>
    <div class="row-item">
        <input name="speaker" type="text" value="<?=$speaker;?>" class="required">
    </div>
    <div class="row-item">
        <textarea name="text" class="required"><?=$text;?></textarea>
    </div>
    <div class="form-row">
        <div class="yellow-attach">
            <input type="file" name="audio" id="file-<?=$id;?>" class="inputfile inputfile-1 audio_file" accept="audio/*">
            <label for="file-<?=$id;?>" class="attach"> <span><?=(!empty($audio_name)) ? $audio_name : 'Прикрепить...';?></span></label>
            <input type="hidden" name="audio_change" value="0">
        </div>
    </div>
    <div class="row-item">
        <div class="btns-control">
            <button type="submit" class="btn-save btn-save-green">Сохранить</button>
            <a class="btn-cancel" href="#">Удалить</a>
        </div>
    </div>
</form>