<div class="activity-block">
    <div class="mask"></div>
    <div class="ab3-bg"></div>
    <div class="activity-block_title">Развивающие мероприятия</div>
    <div class="activity-toggle">список<br> мероприятий
        <div class="activty-toggle_menu"><span></span></div>
        <div class="activity-toggle-block">
            <div class="activity-toggle-block_head">
                <div class="logo"></div>
                <span>XVI Межрегиональная научно-техническая конференция молодых специалистов
                                ПАО&nbsp;«НК&nbsp;«Роснефть»</span>
            </div>
            <div class="activity-toggle-block_list">
                <div class="activity-toggle-block_list-title">Развивающие мероприятия</div>
                <a class="toggle-block_list-title" href="/acquaintance">Знакомство</a>
                <a class="toggle-block_list-title">Мастер-классы</a>
                <?if(!empty($events_type_1)):?>
                    <? foreach ($events_type_1 as $event):?>
                        <a href="/events/<?=$event['id'] ?? '';?>"><?=$event['title'] ?? '';?><div class="arrow"></div></a>
                    <?endforeach;?>
                <?endif;?>
                <a class="toggle-block_list-title">Время эксперотов</a>
                <?if(!empty($events_type_2)):?>
                    <? foreach ($events_type_2 as $event):?>
                        <a href="/events/<?=$event['id'] ?? '';?>"><?=$event['title'] ?? '';?><div class="arrow"></div></a>
                    <?endforeach;?>
                <?endif;?>
            </div>
        </div>
    </div>
</div>