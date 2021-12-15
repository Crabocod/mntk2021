<tr>
    <td>
        <div class="row-item">
            <p><?=@$group_title;?></p>
        </div>
    </td>
    <td>
        <div class="row-item">
            <p><?=@$user_group_count;?></p>
        </div>
    </td>
    <td>
        <div class="row-item">
            <div class="toggle-list">
                <a class="toggle-list__open unselectable">раскрыть...</a>
                <div class="hidden-toggle" style="display: none">
                    <?foreach (@$users as $user):?>
                    <p><?=$user['surname'].' '.$user['name'].' - '.$user['email'];?></p>
                    <?endforeach;?>
                </div>
            </div>
        </div>
    </td>
</tr>