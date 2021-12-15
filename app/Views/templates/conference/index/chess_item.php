<a class="event-block" href="<?=$page_url ?? '';?>">
    <div class="events-mobile_block">
        <div class="event-block_cirkle">
            <img width="30px" src="<?=$img_link ?? '';?>" alt="">
        </div>
        <div class="event-block_title">
            <?=$day ?? '';?> <?=$month ?? '';?>
            <p>Время начала: <?=$time ?? '';?></p>
        </div>
    </div>
    <div class="event-btn"><?=$type ?? '';?></div>
    <div class="event-block_caption"><?=$title ?? '';?></div>
</a>