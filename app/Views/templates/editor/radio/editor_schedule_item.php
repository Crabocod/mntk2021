<tr class="update-row">
    <input type="hidden" name="live_id" value="<?=@$id;?>">
    <td style="max-width: 100px">
        <div class="row-item">
            <input type="text" name="title" placeholder="Название" value="<?=$title;?>">
        </div>
    </td>
    <td>
        <div class="row-item row-2-items">
            <input name="date" type="text" value="<?=$date;?>" class="litepicker-date required" placeholder="дд.мм.гггг" autocomplete="off">
            <div class="-flex -center">
                <input class="required" type="time" name="date_from" autocomplete="off" value="<?=$date_from;?>">
                &nbsp;-&nbsp;
                <input class="required" type="time" name="date_to" autocomplete="off" value="<?=$date_to;?>">
            </div>
        </div>
    </td>
    <td>
        <div class="row-item row-2-items">
            <input type="text" name="speaker" placeholder="Спикер" value="<?=$speaker;?>">
            <textarea name="text" class="height-100"><?=$text;?></textarea>
        </div>
    </td>
    <td width="100px">
        <form>
            <?if(!empty(@$img)):?>
                <div class="row-item row-image">
                    <div class="thumbnail_div">
                        <input name="img" type="file" class="thumbnail" accept="image/*">
                        <input type="hidden" name="deleted_img" value="0">
                        <span style="display: none">Прикрепить изображение</span>
                        <img class="image" src="/<?=@$img;?>" alt="" draggable="false">
                    </div>
                    <img class="image__delete" src="/img/delete-krest.svg">
                </div>
            <?else:?>
                <div class="row-item row-image">
                    <div class="thumbnail_div">
                        <input name="img" type="file" class="thumbnail" accept="image/*">
                        <input type="hidden" name="deleted_img" value="0">
                        <span>Прикрепить изображение</span>
                        <img class="image" src="" alt="" draggable="false" style="display: none">
                    </div>
                    <img class="image__delete" src="/img/delete-krest.svg" style="display: none">
                </div>
            <?endif;?>
        </form>
    </td>
    <td>
        <div class="row-item">
                <a class="btn-save" href="#">Сохранить</a>
                <a class="btn-cancel-black" href="#">Удалить</a>
        </div>
    </td>
</tr>