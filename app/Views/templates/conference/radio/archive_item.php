<div class="efir-archive__item item-<?=$count;?>" <?=($count!=1)?'style="display:none;"':'';?>>
    <div class="efir-archive__title"><span><?=$date;?>: </span><?=$title;?></div>
    <p><?=$speaker?> <?=$text;?></p>
    <audio controls controlsList="nodownload">
        <source src="/<?=$audio;?>" type="audio/mpeg">
        Тег audio не поддерживается вашим браузером.
    </audio>
</div>