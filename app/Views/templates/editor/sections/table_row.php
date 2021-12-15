<tr class="tr-link" section_id="<?=@$id;?>">
    <td>
        <div class="row-item">
            <p><?=@$title_1;?></p>
        </div>
    </td>
    <td>
        <div class="row-item">
            <p><?=@$title_2;?></p>
        </div>
    </td>
    <td>
        <div class="row-item">
            <p><?=@$protection_date;?></p>
        </div>
    </td>
    <td>
        <div class="row-item">
            <p><?=@$protection_time;?></p>
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