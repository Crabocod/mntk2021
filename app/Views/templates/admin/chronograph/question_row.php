<form class="row-form question_rows">
    <input type="hidden" name="id" value="<?=@$id?>">
    <div class="row-form_item w-0">
        <input class="input-chrono" type="text" name="number" value="<?=@$number?>">
    </div>
    <div class="row-form_item">
        <textarea name="text"><?=@$text?></textarea></div>

    <div class="row-form_item w-1"> <label for="image-upload-<?=@$id?>" class="crhrono-label">
        <?=mb_strimwidth(@$img_title, 0, 20, "...")?></label>

        <input name="img_link" class="invisible" id="image-upload-<?=@$id?>" type="file"
               accept="image/*" />
        <?if($img_title != 'Прикрепить изображение'):?>
        <div class="delete-photo js-delete-img"></div>
        <?endif;?>
        <input type="hidden" name="delete-img" value="0">
    </div>

    <div class="row-form_item w-2">
        <label for="audio-upload-<?=@$id?>" class="crhrono-label"> <?= mb_strimwidth(@$audio_title, 0, 20, "...")?></label>

        <input name="audio_link" class="invisible" id="audio-upload-<?=@$id?>" type="file" accept="audio/*" />
        <?if($audio_title != 'Прикрепить аудио'):?>
            <div class="delete-photo js-delete-audio"></div>
        <?endif;?>
        <input type="hidden" name="delete-audio" value="0">
    </div>

    <div class="row-form_item w-3">
        <label for="file-upload-<?=@$id?>" class="crhrono-label"> <?= mb_strimwidth(@$file_title, 0, 20, "...")?></label>

        <input name="file_link" class="invisible" id="file-upload-<?=@$id?>" type="file" />
        <?if($file_title != 'Прикрепить файлы'):?>
            <div class="delete-photo js-delete-file"></div>
        <?endif;?>
        <input type="hidden" name="delete-file" value="0">
    </div>
    <div class="row-form_item w-4">
        <input name="youtube_iframe" class="required" type="text" value="<?=htmlspecialchars(@$youtube_iframe)?>">
    </div>
    <div class="row-form_item">
        <button class="crhono-btn save-question">Сохранить</button>
        <button class="crhono-btn delete-question" data-id="<?=@$id?>">Удалить</button>
    </div>
    <div class="row-form_item">
        <div class="checkbox">
            <input <?=($show == 1)?'checked':''?> type="checkbox" class="custom-checkbox" id="public-<?=@$id?>" value="1"
                   name="show">
            <label for="public-<?=@$id?>"></label>
        </div>
    </div>
</form>