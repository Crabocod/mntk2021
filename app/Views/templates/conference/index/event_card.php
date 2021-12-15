<div class="yellow-bg">
    <div class="news-index__item">
        <a class="news-index__title" href="/<?= $url_segment; ?>/events/<?= $id; ?>">
            <?= $title; ?>
        </a>
        <div class="news-index__meta -flex">
            <div class="data"><?= $date; ?></div>
            |
            <div class="author">Спикер: <?= $speaker; ?></div>
        </div>
        <div class="news-index__content -flex">
            <?if(!empty($preview_img)):?>
                <img src="<?= $preview_img; ?>" alt="">
            <?endif;?>
            <div class="news-index__text">
                <p><?= $short_text; ?></p>
                <a href="/<?= $url_segment; ?>/events/<?= $id; ?>" class="read-more">Подробнее</a>
            </div>
        </div>
    </div>
</div>