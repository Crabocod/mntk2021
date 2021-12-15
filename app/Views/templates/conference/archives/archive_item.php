<div class="arhive-block">
    <div class="arhive-block_date"><?=$date ?? '';?></div>
    <div class="arhive-block_name"><?=$title ?? '';?></div>
    <?if(!empty($youtube_iframe)):?>
        <?=$youtube_iframe ?? '';?>
        <div class="arhive-block_sub">Видео</div>
    <?endif;?>
    <?if(!empty($presentation_file_link)):?>
        <a target="_blank" href="<?=$presentation_file_link;?>" class="arhive-block_btn">СКАЧАТЬ МАТЕРИАЛЫ</a>
    <?endif;?>
</div>