<?php
$dateFormatter = new \App\Libraries\DateFormatter();
$created_at = '';
if(!empty($feedback['created_at'])) {
    $feedback['created_at'] = \App\Libraries\DateTime::byUserTimeZone(\App\Entities\Users\UserSession::getUser(), $feedback['created_at']);
    $created_at = $dateFormatter->withRelativeDate(true, true)->format_3($feedback['created_at']);
}
$grade_class = '';
if(!empty($feedback['grade']) && $feedback['grade'] == 1)
    $grade_class = 'like';
elseif(!empty($feedback['grade']) && $feedback['grade'] == 2)
    $grade_class = 'dis';
?>

<div class="new-reviews_block">
    <div class="reviews_block-name"><?=$feedback['user_full_name'] ?? '';?>
        <?if(!empty($grade_class)):?>
            <div class="grade-block active <?=$grade_class;?>">
                <div class="like-svg"></div>
            </div>
        <?endif;?>
    </div>
    <div class="new-reviews_date"><?=$created_at ?? '';?></div>
    <div class="new-reviews_text"><?=(!empty($feedback['text'])) ? esc($feedback['text']) : '';?></div>
</div>