<?php use App\Libraries\DateTime;

$this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Главная']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo view('templates/all/header'); ?>
<?php echo view('templates/all/submenu'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <?if(!empty(@$conferences->ticker)):?>
    <div class="run-text__content">
        <marquee behavior="scroll" direction="left"><?=$conferences->ticker;?></marquee>
    </div>
    <?endif;?>


    <div class="content">
        <div class="container">
            <?if($conferences->show_timer_block == 1):?>
            <!-- Таймер -->
            <div class="timer-block">
                <div class="timer__article__title" align="center">Прямая трансляция начнется через:</div>
                <br>
                <div class="timer"
                <?=(!empty($conferences->timer_datetime))?'data-finish="'.DateTime::byUserTimeZone(\App\Entities\Users\UserSession::getUser(), $conferences->timer_datetime).'"':'';?>
                >
                    <div class="timer_section">
                        <div class="days_1">0</div>
                        <div class="days_2">0</div>
                        <div class="timer_section_desc">дней</div>
                    </div>
                    <div class="timer_delimetr">:</div>
                    <div class="timer_section">
                        <div class="hours_1">0</div>
                        <div class="hours_2">0</div>
                        <div class="timer_section_desc">часов</div>
                    </div>
                    <div class="timer_delimetr">:</div>
                    <div class="timer_section">
                        <div class="minutes_1">0</div>
                        <div class="minutes_2">0</div>
                        <div class="timer_section_desc">минут</div>
                    </div>
                    <div class="timer_delimetr">:</div>
                    <div class="timer_section">
                        <div class="seconds_1">0</div>
                        <div class="seconds_2">0</div>
                        <div class="timer_section_desc">секунд</div>
                    </div>
                </div>
                <!--            <br>-->
                <!--            <p align="center" class="article__title"><a class="knopka" target="_blank" href="https://mntk.aetc-spb.ru">ПРОСМОТР ТРАНСЛЯЦИИ</a></p>-->
                <br><br>
            </div>
            <!-- Таймер -->
            <?endif;?>

            <?if($conferences->show_ether_block == 1):?>
                <!-- Прямой эфир -->
                <div class="row">
                    <?=($conferences->ether_iframe);?>
                </div>
                <!-- Прямой эфир -->
            <?endif;?>

            <?if($conferences->show_eventsnews_block == 1):?>
                <?if(!empty($event_card) or !empty($news_card)):?>
                    <div class="news-index__list">
                        <?if(!empty(@$event_card)):?>
                            <div class="yellow-bg">
                                <h2>Ближайшие мероприятия</h2>
                            </div>
                            <?=@$event_card[0];?>
                            <?=(!empty($event_card[1]))?$event_card[1]:'<div></div>';?>
                        <?endif;?>
                        <?if(!empty(@$news_card)):?>
                            <div class="grey-bg">
                                <h2>Живая лента</h2>
                            </div>
                            <?=@$news_card[0];?>
                            <?=(!empty($news_card[1]))?$news_card[1]:'<div></div>';?>
                        <?endif;?>
                    </div>
                <?endif;?>
            <?endif;?>

            <?if($conferences->show_main_block == 1):?>
                <div class="row">
                    <div class="col-8">
                        <div class="index-welcome">
                            <h2><?=@$conferences->gr_title;?></h2>
                            <br>
                            <!--<div class="index-welcome__logo -flex -center">
                            <img src="/<?=@$conferences->gr_logo;?>" alt="">
                            <div class="logo-text"><?=@$conferences->gr_title;?></div>
                        </div>-->
                            <div class="ck-content">
                                <?=@$conferences->gr_text;?>
                            </div>
                        </div>
                    </div>
                    <?=@$barrel_block;?>
                </div>
            <?endif;?>

            <?if(!empty($chess_section)):?>
            <div class="title">
                Мероприятия КНТК 2021
            </div>

            <div class="c-row calendar__list chess-events">
                <?=@$chess_section;?>
            </div>
            <?endif;?>

            <?if(!empty($team_quest_section)):?>
            <div class="title">
                Результаты сквозного <br>командного квеста
            </div>
            <div class="c-row result__quest__list-row">
                <?=@$team_quest_section;?>
            </div>
            <?endif;?>

        </div>

    </div>


<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
<script src="/js/conference/index-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>
