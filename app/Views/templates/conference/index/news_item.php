<div class="news-row">
    <div class="news-row_text-block">
        <div class="news-row_title">
            <a href="/news/<?= $id ?? ''; ?>"><?=$title ?? '';?></a>
            <p><?=$date ?? '';?></p>
        </div>
        <div class="news-row_text">
            <?=$short_text ?? '';?>
        </div>
    </div>
    <?if(!empty($photo_file_link) || !empty($photo_min_file_link)):?>
    <picture class="news-row_img">
        <img src="<?=$photo_min_file_link ?? $photo_file_link ?? '';?>" />
    </picture>
    <?endif;?>
    <?=$youtube_iframe ?? '';?>
</div>