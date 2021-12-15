<div class="event__item">
    <div class="event__title">
        <a href="/<?= $url_segment; ?>/news/<?= $id; ?>" class="event__title-href">
            <?=$title;?>
        </a>
    </div>
    <div class="event__meta -flex">
        <div class="data"><?=$date;?></div>
    </div>
    <div class="event__content -flex">
        <div class="event__text ck-content">
            <?=$short_text;?>
            <a href="/<?= $url_segment; ?>/news/<?= $id; ?>" class="read-more">Подробнее</a>
        </div>
    </div>
</div>