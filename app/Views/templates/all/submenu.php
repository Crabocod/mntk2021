<div class="submenu">
    <div class="container -flex -center -justify-btw -wrap">
        <img style="cursor: pointer" onclick="document.location.href='/<?=$conferences->url_segment;?>/radio'" src="/img/radio.png" height="64px">
        <? $detect = new Mobile_Detect(); if(!$detect->isiOS()):?>
            <div style="display: none" id="jquery_jplayer_1" class="jp-jplayer" mp3_src="<?=(!empty($conferences->radio_audio)?'/'.$conferences->radio_audio:(!empty($conferences->radio_iframe)?$conferences->radio_iframe:''));?>"></div>
            <div id="jp_container_1" class="jp-audio index-jp-audio">
                <div class="jp-type-single">
                    <div class="jp-gui jp-interface">
                        <ul class="jp-controls">
                            <li><a href="javascript:;" class="jp-play" tabindex="1"></a></li>
                            <li><a href="javascript:;" class="jp-pause" tabindex="1" style="display: none;"></a>
                            </li>
                            <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute"></a></li>
                            <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"
                                   style="display: none;"></a>
                            </li>
                        </ul>
                        <div class="jp-no-solution">
                            <span>Update Required</span>
                            To play the media you will need to either update your browser to a recent version or
                            update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                        </div>
                    </div>
                </div>
            </div>
        <?else:?>
            <audio class="index-audio" controls>
                <source src="<?=(!empty($conferences->radio_audio)?'/'.$conferences->radio_audio:(!empty($conferences->radio_iframe)?$conferences->radio_iframe:''));?>" type="audio/mpeg">
            </audio>
        <?endif;?>
        <a class="prof-vikt" href="/<?=$conferences->url_segment;?>/prof-quiz">
            Профессиональная <br>
            викторина
        </a>
        <a class="uz-region" href="/<?=$conferences->url_segment;?>/region-quiz">
            Викторина <br>
            «Узнай регион»
        </a>
        <a class="sub-feedback" href="/<?=$conferences->url_segment;?>/feedback">
            Обратная <br>
            связь
        </a>
<!--        <a class="sub-wantmemb" href="/--><?//=$conferences->url_segment;?><!--/member">-->
<!--            Хочу стать участником...-->
<!--        </a>-->
    </div>
</div>