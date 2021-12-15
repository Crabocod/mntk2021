<div class="activity-block">
    <div class="mask"></div>
    <div class="ab4-bg"></div>
    <div class="activity-block_title">Oil English club</div>
    <div class="activity-toggle">список<br> мероприятий
        <div class="activty-toggle_menu"><span></span></div>
        <div class="activity-toggle-block">
            <div class="activity-toggle-block_head">
                <div class="logo"></div>
                <span>XVI Межрегиональная научно-техническая конференция молодых специалистов
                                ПАО&nbsp;«НК&nbsp;«Роснефть»</span>
            </div>
            <div class="activity-toggle-block_list">
                <div class="activity-toggle-block_list-title">Oil English club</div>
                <?if(!empty($events_type_4)):?>
                    <? foreach ($events_type_4 as $event):?>
                        <a href="/events/<?=$event['id'] ?? '';?>"><?=$event['title'] ?? '';?><div class="arrow"></div></a>
                    <?endforeach;?>
                <?endif;?>
            </div>
        </div>
    </div>
</div>