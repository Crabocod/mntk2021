<div class="timer-block" style="<?=(!empty($hide)) ? 'display:none' : '';?>">
    <div class="container">
        <div class="main-block">
            <div class="logo"
                 style="<?=(!empty($conference['logo_file']['link'])) ? 'background: url('.$conference['logo_file']['link'].')' : '';?>">
            </div>
            <div class="main-title"><?=$conference['title'] ?? '';?>
                <p>XVI Межрегиональная научно-техническая конференция молодых специалистов
                    ПАО «НК «Роснефть»
                </p>
            </div>
        </div>
        <div class="timer__article__title">Прямая трансляция начнется через:</div>
        <br>
        <div class="<?=(empty($hide)) ? 'timer' : '';?>" data-finish="<?=(!empty($conference['timer'])) ? \App\Libraries\DateTime::byUserTimeZone(\App\Entities\Users\UserSession::getUser(), $conference['timer']) : '0000:00:00 00:00:00';?>">
            <div class="timer_section">
                <div class="timer-f">
                    <div class="days_1">3</div>
                    <div class="days_2">4</div>
                </div>
                <div class="timer_section_desc">дней</div>
            </div>
            <div class="timer_delimetr">:</div>
            <div class="timer_section">
                <div class="timer-f">
                    <div class="hours_1">1</div>
                    <div class="hours_2">5</div>
                </div>
                <div class="timer_section_desc">часов</div>
            </div>
            <div class="timer_delimetr">:</div>
            <div class="timer_section">
                <div class="timer-f">
                    <div class="minutes_1">1</div>
                    <div class="minutes_2">8</div>
                </div>
                <div class="timer_section_desc">минут</div>
            </div>
            <div class="timer_delimetr">:</div>
            <div class="timer_section">
                <div class="timer-f">
                    <div class="seconds_1">5</div>
                    <div class="seconds_2">1</div>
                </div>
                <div class="timer_section_desc">секунд</div>
            </div>
        </div>
        <!--            <br>-->
        <!--            <p align="center" class="article__title"><a class="knopka" target="_blank" href="https://mntk.aetc-spb.ru">ПРОСМОТР ТРАНСЛЯЦИИ</a></p>-->
    </div>
</div>