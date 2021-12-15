<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Развивающие мероприятия']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="programs-page events-about">
    <div class="container">
        <div class="programs-block">
            <div class="theme-block">
                <div class="programs-block_title"><?=$event_type_title ?? '';?> <span
                        class="progrmas-date"><?=$date ?? '';?></span> <span
                        class="progrmas-time"><?=$duration ?? '';?></span></div>
                <div class="programs-block_theme"><?=$title ?? '';?></div>
                <div class="programs-info_blocks">
                    <?if(!empty($photo_file_link) || !empty($photo_min_file_link)):
                        $photo_link = !(empty($photo_file_link)) ? $photo_file_link : $photo_min_file_link;
                        ?>
                    <div class="programs-info_block">
                        <picture>
                            <img src="<?=(!empty($photo_link)) ? '/'.$photo_link : '';?>">
                        </picture>
                    </div>
                    <?endif;?>
                    <div class="programs-text_block">
                        <div class="programs-text_block-title">
                            <span>Модератор:</span> <?=$speaker ?? '';?>
                        </div>
                        <div class="programs-text_block-text ck-content">
                            <?=$about_speaker ?? '';?>
                        </div>
                    </div>
                </div>
                <div class="programs-info_blocks-sub ck-content">
                    <?=$full_text ?? '';?>
                </div>
                <a class="programs-btn programs-sign js-sign-up"
                    <?=($this_user_signed ?? false)?'disabled="disabled"':'';?>
                    href="#"><?=($this_user_signed ?? false)?'ВЫ ЗАПИСАНЫ':'ЗАПИСАТЬСЯ';?></a>
            </div>

            <div class="speak-block">
                <div class="speak-block_info">
                    <?if(!empty($presentation_file_link)):?>
                    <a class="speak-block_info-block" target="_blank" href="/<?=$presentation_file_link;?>">
                        <div class="power-point"></div>
                        <picture>
                            <img src="/img/speak-block.png">
                        </picture>
                    </a>
                    <?endif;?>
                    <?if(!empty($youtube_iframe)):?>
                    <div class="speak-block_info-block">
                        <?=$youtube_iframe;?>
                    </div>
                    <?endif;?>
                </div>
                <a class="programs-btn" href="#" data-remodal-target="comment"><img src="/img/speak-btn.svg">ВЫСКАЖИТЕСЬ
                    ПО ТЕМЕ ВСТРЕЧИ</a>
            </div>
            <?if(!empty($feedbacks)):?>
                <div class="new-reviews_blocks" id="feedback_rows">
                <?foreach ($feedbacks as $feedback):?>
                    <?=view('templates/conference/all/feedback_row', ['feedback' => $feedback]);?>
                <?endforeach;?>
                </div>
            <?endif;?>
            <?if(!empty($gallery)):?>
            <div class="photo-report_block">
                <h2>фотоотчет</h2>
                <div class="photo-slides">
                    <?foreach ($gallery as $photo):?>
                    <div class="photo-slide">
                        <picture>
                            <img src="/<?=$photo['photo_min_file_link'] ?? '';?>">
                        </picture>
                    </div>
                    <?endforeach;?>
                </div>
            </div>
            <?endif;?>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>

<?php $this->section('footer'); ?>
<?php echo $this->include('templates/all/footer'); ?>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
<script src="/js/jstz.min.js"></script>
<script src="/js/conference/events-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>