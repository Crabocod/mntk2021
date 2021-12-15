<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => $event_type_title ?? '']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="timeline-about">
        <div class="programs-page events-about">
            <div class="container">
                <div class="programs-block">
                    <a class="back-admin" href="/archives">
                        <div class="arrow"></div>
                        Вернуться назад
                    </a>
                    <div class="programs-block_theme"><?=$archive['title'] ?? '';?></div>
                    <div class="news-row_title">
                        <p><?=$archive['formatted_date_from'] ?? '';?></p>
                    </div>
                    <div class="news-row_text ck-content"><?=$archive['full_text'] ?? '';?></div>
                    <div class="news-row_about">

                        <?if(!empty($archive['photo_link'])):?>
                        <picture>
                            <img src="/<?=$archive['photo_link'];?>">
                        </picture>
                        <?endif;?>
                        <?=$archive['youtube_iframe'] ?? '';?>
                    </div>
                </div>
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