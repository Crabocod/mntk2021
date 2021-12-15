<div class="admin-block" data-block_id="3">
    <div class="injection">
        <a href="#" class="js-toggle-visible"><img src="<?=(!empty($hide)) ? '/img/hide.svg' : '/img/visible.svg';?>" alt=""></a>
        <a href="#" class="handle"><img src="/img/move.svg" alt=""></a>
    </div>
    <h4>Таймер</h4>
    <div class="sub-h4">Выберите дату и время по вашему часовому поясу</div>
    <form class="inputs" id="timer">
        <input type="date" name="timer_date" value="<?=(!empty($conference['timer']))?date('Y-m-d', strtotime($conference['timer'])):'';?>">
        <input value="<?=(!empty($conference['timer']))?date('H:i', strtotime($conference['timer'])):'';?>" class="required" type="time" name="timer_time" autocomplete="off">
    </form>
</div>