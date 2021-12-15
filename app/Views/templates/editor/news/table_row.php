<tr class="tr-link" news_id="<?=@$id;?>">
    <td onclick="window.location.href='/editor/<?=@$conference_id;?>/news/<?=$id;?>'; return false">
        <div class="row-item">
            <p><?=@$date;?></p>
        </div>
    </td>
    <td onclick="window.location.href='/editor/<?=@$conference_id;?>/news/<?=$id;?>'; return false">
        <div class="row-item">
            <p><?=@$title;?></p>
        </div>
    </td>
    <td class="td-checkbox">
        <div class="row-item">
            <label class="class-checkbox <?=(@$is_publication==1)?'active':'';?>" for="chec-2">
                <input name="is_publication" type="checkbox" <?=(@$is_publication==1)?'checked':'';?>>
            </label>
        </div>
    </td>
</tr>