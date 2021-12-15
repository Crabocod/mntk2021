<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => $news_title ?? '']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="timeline-about">
    <div class="programs-page events-about">
        <div class="container">
            <div class="programs-block">
                <a class="back-admin" href="/news">
                    <div class="arrow"></div>
                    Вернуться назад
                </a>
                <div class="programs-block_theme"><?=$news['title']?></div>
                <div class="news-row_title">
                    <p><?=date('d.m.Y', strtotime($news['date']))?></p>
                </div>
                <div class=" ck-content">
                    <?=$news['full_text']?></div>
                <div class="news-row_about">
                    <picture>
                        <img src="/<?=(!empty($news['file_min_link']) ? $news['file_min_link'] : ($news['file_link'] ?? ''));?>">
                    </picture>
                    <?=$news['youtube_iframe']?>
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