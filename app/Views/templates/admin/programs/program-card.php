<div class="row-form" data-id="<?=$id?>">
    <div class="row-form_item">
        <img src="/<?= (!empty($file_min_link))?$file_min_link:$file_link?>" alt="">
    </div>

    <div class="row-form_item"><?=@$title?></div>
    <div class="row-form_item"><?=@$text?></div>
    <div class="row-form_item">
        <div class="checkbox">
            <input <?=($is_published)?'checked':''?> type="checkbox" class="custom-checkbox" id="public-<?=@$id?>" value="1"
                   name="chb-confirm-1" data-id="<?=$id?>">
            <label class="checkbox-js" for="public-<?=@$id?>"></label>
        </div>
    </div>
    <div class="row-form_item ">
        <div class="btn-cancel js-delete" data-id="<?=$id?>"></div>
    </div>
</div>