<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Деловая программа']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="events-page">
    <div class="accuainatce_page">
        <div class="container">
            <div class="programs-block">
                <div class="first-block">
                    <h2><?=$program['title']?></h2>
                    <div class="events-page_text ck-content"><?=$program['text']?></div>
                    <div class="events-page_date"><?=$program['date']?></div>
                    <a class="programs-btn" href="#">Смотреть <img src="/img/play.svg" alt=""></a>
                </div>
                <div class="second-block">
                    <?=@$program['youtube_iframe']?>
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
<script src="/js/auth-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>
