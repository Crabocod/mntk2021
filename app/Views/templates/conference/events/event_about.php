<div class="content">
    <div class="container">
        <a href="/<?= $url_segment ?>/events" class="go-back"><- Вернуться назад</a>
        <div class="single__event">
            <div class="single__event__header -flex">
                <div class="single__event__title"><?= $title; ?></span></div>
                <input type="hidden" class="event-id" value="<?= $id; ?>">
                <?if(!empty($show_button)):?>
                <a class="btn-yellow-small ajax-event-sign <?= $sign_class; ?>" <?= ($sign_class != '') ? 'disabled' : ''; ?>
                   href="#"><?= $sign_text; ?></a>
                <?endif;?>
            </div>
            <div class="single__event__meta -flex">
                <div class="data"><?= @$date; ?> в <?= @$time; ?></div>
                |
                <div class="author">Спикер: <?= $speaker; ?></div>
            </div>
            <div class="single__event__content ck-content">
                <?= $full_text; ?>
                <!--                <a class="btn-yellow-lx ajax-event-sign --><? //=$sign_class;?><!--" -->
                <? //= ($sign_class != '') ? 'disabled' : '';?><!-- href="#">--><? //=$sign_text;?><!--</a>-->
            </div>
        </div>
    </div>
</div>