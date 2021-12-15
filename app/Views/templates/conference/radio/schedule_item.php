<div class="efir__item">
    <div class="efir__data"><?=$date;?></div>
    <div class="efir__item__content">
        <div class="efir__name"><?=$title;?></div>
        <div class="-flex">
            <?if(!empty($img)):?>
            <div class="efir__img">
                <img class="efir__img__round" src="/<?=$img;?>" alt="">
            </div>
            <?endif;?>
            <div class="efir__text">
                <div class="efir__time"><?=$date_from;?> – <?=$date_to;?></div>
                <div class="efir__author"><?=$speaker;?></div>
                <p><?=$text;?></p>
            </div>
        </div>
    </div>
</div>