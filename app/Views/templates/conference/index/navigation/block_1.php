<div class="activity-block">
    <div class="ab1-bg"></div>
    <div class="mask"></div>
    <div class="activity-block_title">Деловая программа</div>
    <div class="activity-toggle">список<br> мероприятий
        <div class="activty-toggle_menu"><span></span></div>
        <div class="activity-toggle-block">
            <div class="activity-toggle-block_head">
                <div class="logo"></div>
                <span>XVI Межрегиональная научно-техническая конференция молодых специалистов
                                ПАО&nbsp;«НК&nbsp;«Роснефть»</span>
            </div>
            <div class="activity-toggle-block_list">
                <div class="activity-toggle-block_list-title">Деловая программа</div>
                <?if(!empty($business_programs)):?>
                    <? foreach ($business_programs as $business_program):?>
                        <a href="/programs/<?=$business_program->id ?? '';?>"><?=$business_program->title ?? '';?><div class="arrow"></div></a>
                    <?endforeach;?>
                <?endif;?>
            </div>
        </div>
    </div>
</div>