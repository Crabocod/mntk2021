<div class="activity-block">
    <div class="mask"></div>
    <div class="ab2-bg"></div>
    <div class="activity-block_title">Работа жюри</div>
    <div class="activity-toggle">список<br> мероприятий
        <div class="activty-toggle_menu"><span></span></div>
        <div class="activity-toggle-block">
            <div class="activity-toggle-block_head">
                <div class="logo"></div>
                <span>XVI Межрегиональная научно-техническая конференция молодых специалистов
                                ПАО&nbsp;«НК&nbsp;«Роснефть»</span>
            </div>
            <div class="activity-toggle-block_list">
                <div class="activity-toggle-block_list-title">Список секций</div>
                <?if(!empty($sections)):?>
                    <? foreach ($sections as $section):?>
                        <a href="/sections/<?=$section['id'] ?? '';?>"><?=$section['title'] ?? '';?> <br>Секция №<?=$section['number'] ?? '';?><div class="arrow"></div></a>
                    <?endforeach;?>
                <?endif;?>
            </div>
        </div>
    </div>
</div>