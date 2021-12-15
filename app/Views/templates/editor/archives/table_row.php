<div class="row-form" data-id="<?=$id ?? '';?>">
    <div class="row-form_item">
        <?if(!empty($preview_link)):?>
            <img src="<?='/'.$preview_link;?>" alt="">
        <?endif;?>
    </div>
    <div class="row-form_item"><?=$formatted_date_from ?? '';?><br><?=$time_from ?? '';?></div>
    <div class="row-form_item"><?=$title ?? '';?></div>
    <div class="row-form_item">
        <?=$speaker ?? '';?>
    </div>
    <div class="row-form_item">
        <div class="checkbox">
            <input type="checkbox" class="custom-checkbox" id="public" value="1"
                   name="chb-confirm-1" <?=(!empty($is_published)) ? 'checked' : '';?>>
            <label for="public"></label>
        </div>
    </div>
</div>