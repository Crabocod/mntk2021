<form class="grid grid-6 body-grid shahmatka-grid-6 chess-row add-user user-rows">
    <input type="hidden" name="id" value="<?=@$id?>">
    <div class="row-item">
        <input name="full_name" type="text" value="<?=@$full_name?>">
    </div>
    <div class="row-item-date row-item">
        <input type="number" name="section_id" value="<?=@$section_id?>">
    </div>
    <div class="row-item">
        <input name="phone" class="MaskedPhone" type="text" value="<?=@$phone?>">
    </div>
    <div class="row-item">
        <input name="email" type="mail" value="<?=@$email?>">
    </div>
    <div class="row-item">
        <input name="og_title" type="text" value="<?=(!empty($og_title)) ? esc($og_title) : '';?>">
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