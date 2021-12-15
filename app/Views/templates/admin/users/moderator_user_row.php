<form class="grid grid-6 body-grid shahmatka-grid-6 chess-row add-user user-rows">
    <input type="hidden" name="id" value="<?=@$id?>">
    <div class="row-item">
        <input name="full_name" type="text" value="<?=@$full_name?>">
    </div>
    <div class="row-item">
        <input name="email" type="mail" value="<?=@$email?>">
    </div>
    <div class="row-item">
        <select name="role_id" class="select">
            <option disabled>Выбрать</option>
            <option value="1" <?=($role_id == 1)?'selected':''?> >Администратор</option>
            <option value="2" <?=($role_id == 2)?'selected':''?>>Модератор</option>
        </select>
    </div>
    <div class="row-item">
        <div class="btns-control">
            <button type="submit" class="btn">Сохранить</button>
            <a href="#">
                <div class="btn-cancel js-delete" data-id="<?=@$id?>"></div>
            </a>
            <a href="#">
                <div class="btn-mail js-mail" data-id="<?=@$id?>"></div>
            </a>
        </div>
    </div>
</form>