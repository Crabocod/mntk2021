<div class="grid grid-5 body-grid jq-save">
    <div class="row-item ajax-name">
        <input type="text" value="<?=$name;?>">
    </div>
    <div class="row-item ajax-surname">
        <input type="text" value="<?=$surname;?>">
    </div>
    <div class="row-item ajax-email">
        <input type="text" value="<?=$email;?>">
    </div>
    <div class="row-item ajax-perm">
        <select data-placeholder="Выберите доступы" class="chosen-select" multiple tabindex="4">
            <?
                for ($i = 0; $i < count($conferences); $i++){
                    $conferences[$i] = $conferences[$i]->toRawArray();
                    $selected = '';

                    for ($j = 0; $j < count($userConf); $j++){

                        if ($userConf[$j]['conference_id'] == $conferences[$i]['id'] && $userConf[$j]['user_id'] == $id){
                            $selected = 'selected';
                        }
                    }

                    echo '<option value="'.$conferences[$i]['id'].'" '.$selected.' >'.$conferences[$i]['url_segment'].'</option>';
                }
            ?>

        </select>
    </div>
    <div class="row-item">
        <div class="btns-control">
            <a class="btn-save ajax-update" href="#">Сохранить</a>
            <a class="btn-cancel ajax-delete" href="#">Удалить</a>
            <a class="send-pass <?=(@$pass_send == 1)?'hover':'';?>" href="#"></a>
            <input type="hidden" class="user_id" value="<?=@$id;?>">
        </div>
    </div>
</div>