<?php
$nav_items = [
    ['value' => 'Деловая программа'],
    ['value' => 'Работа жюри'],
    ['value' => 'Развивающие мероприятия'],
    ['value' => 'Oil English Club'],
    ['value' => 'Lounge Time'],
    ['value' => 'Хронограф'],
];
?>

<div class="admin-block" data-block_id="2">
    <div class="injection">
        <a href="#" class="js-toggle-visible"><img src="<?=(!empty($hide)) ? '/img/hide.svg' : '/img/visible.svg';?>" alt=""></a>
        <a href="#" class="handle"><img src="/img/move.svg" alt=""></a>
    </div>
    <h4>Навигация</h4>
    <div id="js-sort-nav-items">
        <?if(!empty($sort_navigation_items)):?>
            <?foreach ($sort_navigation_items as $sort_navigation_item):?>
                <div class="event-admin" data-item_id="<?=$sort_navigation_item['id'];?>"><?=$nav_items[$sort_navigation_item['id']-1]['value'] ?? '';?><img class="handle" src="/img/move.svg"></div>
            <?endforeach;?>
        <?else:?>
        <?for ($i=0; $i<count($nav_items); $i++):?>
                <div class="event-admin" data-item_id="<?=$i+1;?>"><?=$nav_items[$i]['value'] ?? '';?><img class="handle" src="/img/move.svg"></div>
        <?endfor;?>
        <?endif;?>
    </div>
</div>