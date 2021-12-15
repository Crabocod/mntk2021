<div class="sayd-zhuri__item">
    <div class="sayd-zhuri__name"><?=$speaker;?></div>
    <?if(!empty($youtube_iframe)) {?>
    <div class="sayd-zhuri__video">
        <div class="video-frame">
            <?=$youtube_iframe;?>
        </div>
    </div>
    <?}?>
    <p><?=$text;?></p>
</div>