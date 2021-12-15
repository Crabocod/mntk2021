<div class="event__item">
    <div class="event__title">
        <a class="event__title-href" href="/<?= $url_segment; ?>/events/<?= $id; ?>">
            <?= $title; ?>
        </a>
    </div>
    <div class="event__meta -flex">
        <div class="data"><?= $date; ?> в <?= $time ;?></div>
        |
        <div class="author">Спикер: <?= $speaker; ?></div>
    </div>
    <div class="event__content -flex">
        <?if(!empty($preview_img)):?>
        <img src="/<?= $preview_img; ?>" alt="">
        <?endif;?>
        <div class="event__text">
            <p class="ck-content"><?= $short_text; ?></p>
            <a href="/<?= $url_segment; ?>/events/<?= $id; ?>" class="read-more">Подробнее</a>
        </div>
    </div>
</div>
