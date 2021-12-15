<div class="yellow-header yellow-header-radio">
    <div class="yellow-header__title"><?=$radio_title;?></div>
    <? if ($radio_date_from != null && $radio_date_to != null) { ?>
    <!--<p><?=@$radio_date_from;?> – <?=@$radio_date_to;?></p>-->
    <?}?>
    <? if ($radio_audio != null) { ?>
    <audio controls controlsList="nodownload">
        <source src="/<?=$radio_audio;?>" type="audio/mpeg">
        Тег audio не поддерживается вашим браузером.
    </audio>
    <?}?>
    <div class="iframe-block">
        <? if ($radio_iframe != null) { ?>
            <?=$radio_iframe;?>
        <?}?>
    </div>
</div>