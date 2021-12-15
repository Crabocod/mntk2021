<tr archive_feedback_id="<?=$id;?>">
    <td>
        <div class="row-item">
            <p><?=@$user_surname;?> <?=@$user_name;?></p>
        </div>
    </td>
    <td>
        <div class="row-item">
            <p><?=@$created_at;?></p>
        </div>
    </td>
    <td>
        <div class="row-item">
            <p><?=esc(@$text);?></p>
        </div>
    </td>
    <td>
        <div class="row-item">
            <p class="text-right"><a class="btn-cancel" href="#">Удалить</a></p>
        </div>
    </td>
</tr>