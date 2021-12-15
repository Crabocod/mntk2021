<tr class="update-row">
    <input type="hidden" name="questions_id" value="<?= @$id; ?>">
    <td>
        <div class="row-item">
            <input name="number" class="input-nom" type="text" value="<?= @$number; ?>">
        </div>
    </td>
    <td>
        <div class="row-item">
            <input type="text" name="youtube_iframe" value="<?= esc(@$youtube_iframe); ?>" placeholder="Код iframe"
                   style="margin-bottom: 4px; width: 100%">
            <textarea name="text" class="height-100" placeholder="Текст"><?= esc(@$text); ?></textarea>
        </div>
    </td>
    <td>
        <form action="">
            <div class="row-item row-image">
                <? if (!empty(@$img)): ?>
                    <div class="thumbnail_div">
                        <input name="img" type="file" class="thumbnail" accept="image/*">
                        <input type="hidden" name="deleted_img" value="0">
                        <span style="display: none">Прикрепить изображение</span>
                        <img class="image" src="/<?= @$img; ?>" alt="" draggable="false">
                    </div>
                    <img class="image__delete" src="/img/delete-krest.svg">
                <? else: ?>
                    <div class="thumbnail_div">
                        <input name="img" type="file" class="thumbnail" accept="image/*">
                        <input type="hidden" name="deleted_img" value="0">
                        <span>Прикрепить изображение</span>
                        <img style="display: none" class="image" src="" alt="" draggable="false">
                    </div>
                    <img class="image__delete" src="/img/delete-krest.svg" style="display: none">
                <? endif; ?>
            </div>
        </form>
    </td>
    <td>
        <form action="">
            <div class="row-item row-audio">
                <div class="thumbnail_div">
                    <input type="file" name="audio" id="file-<?= @$id; ?>" class="inputfile inputfile-1"
                           accept="audio/*">
                    <span><?=(!empty($audio_title))?$audio_title:'Прикрепить аудио';?></span>
                    <img class="audio__delete" src="/img/delete-krest.svg" style="<?=(!empty($audio_title))?'':'display:none';?>">
                    <input type="hidden" name="deleted_audio" value="0">
                </div>
            </div>
        </form>
    </td>
    <td>
        <div class="row-item">
            <div class="">
                <a class="btn-save" href="#">Сохранить</a>
                <a class="btn-cancel-black" href="#">Удалить</a>
            </div>
        </div>
    </td>
    <td>
        <div class="row-item">
            <label class="class-checkbox <?= (@$visibility == 1) ? 'active' : ''; ?>" for="chec-1">
                <input type="checkbox" name="visibility" <?= (@$visibility == 1) ? 'checked' : ''; ?> id="chec-1">
            </label>
        </div>
    </td>
</tr>