<div class="activity-page" style="<?=(!empty($hide)) ? 'display:none' : '';?>">
    <div class="ell-1"></div>
    <div class="container">
        <h2>Навигация</h2>
        <div class="activity-rows">
            <?if(!empty($sort_navigation_items)):?>
                <?foreach ($sort_navigation_items as $sort_navigation_item):?>
                    <?if($sort_navigation_item['id'] == 1):?>
                        <?=view('templates/conference/index/navigation/block_1', array_merge($conference ?? [], $sort_navigation_item));?>
                    <?elseif($sort_navigation_item['id'] == 2):?>
                        <?=view('templates/conference/index/navigation/block_2', $sort_navigation_item);?>
                    <?elseif($sort_navigation_item['id'] == 3):?>
                        <?=view('templates/conference/index/navigation/block_3', $sort_navigation_item);?>
                    <?elseif($sort_navigation_item['id'] == 4):?>
                        <?=view('templates/conference/index/navigation/block_4', $sort_navigation_item);?>
                    <?elseif($sort_navigation_item['id'] == 5):?>
                        <?=view('templates/conference/index/navigation/block_5', $sort_navigation_item);?>
                    <?elseif($sort_navigation_item['id'] == 6):?>
                        <?=view('templates/conference/index/navigation/block_6', $sort_navigation_item);?>
                    <?endif;?>
                <?endforeach;?>
            <?else:?>
                <?=view('templates/conference/index/navigation/block_1');?>
                <?=view('templates/conference/index/navigation/block_2');?>
                <?=view('templates/conference/index/navigation/block_3');?>
                <?=view('templates/conference/index/navigation/block_4');?>
                <?=view('templates/conference/index/navigation/block_5');?>
                <?=view('templates/conference/index/navigation/block_6');?>
            <?endif;?>
        </div>
    </div>
</div>