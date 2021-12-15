<div class="row-form" onclick="document.location.href = '/admin/<?=$event_type_segment ?? '';?>/<?=$id ?? '';?>'">
    <div class="row-form_item">
        <?if(!empty($preview_file_link)):?>
        <img src="<?=(!empty($preview_file_link)) ? '/'.$preview_file_link : '';?>" alt="">
        <?endif;?>
    </div>

    <div class="row-form_item"><?=$formatted_date_from ?? '';?><br><?=$time_from ?? '';?></div>
    <div class="row-form_item"><?=$title ?? '';?></div>
    <div class="row-form_item">
        <?=$speaker ?? '';?>
    </div>
    <div class="row-form_item members">
        Всего: <?=$memberCount ?? 0;?>
        <?if(($waitingCount ?? $waitingCount = 0) > 0){?>
            <p>(<?=$waitingCount;?> на подтверждение)</p>
        <?}?>
    </div>
</div>