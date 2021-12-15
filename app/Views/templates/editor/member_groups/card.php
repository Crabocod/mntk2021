<tr>
    <td>
        <div class="row-item">
            <textarea class="text"><?=$text;?></textarea>
        </div>
    </td>
    <td>
        <form class="icon">
            <input type="hidden" name="id" value="<?=$id;?>">
        <div class="row-item add-icon-row">
            <div class="thumbnail_div" style="max-width: 35px;">
                <input name="img_link" type="file" class="thumbnail" accept="image/*">
                <input type="hidden" name="deleted_icon" value="0">
                <img class="icon" src="/<?=$img;?>" width="30px"/>
                <img class="icon__delete" src="/img/delete-krest.svg">
            </div>
        </div>
        </form>
    </td>
    <td>
        <div class="row-item">
            <div class="btns-control">
                <a class="btn-save ajax-save" href="#">Сохранить</a>
                <a class="btn-cancel ajax-delete" href="#">Удалить</a>
            </div>
        </div>
    </td>
</tr>