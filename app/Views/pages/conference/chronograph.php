<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Хронограф']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="chronograph">
    <div class="programs-page">
        <div class="container">
            <div class="programs-block">
                <div class="theme-block">
                    <div class="programs-block_theme">ХРОНОГРАФ: ВИКТОРИНА</div>
                    <div class="programs-block_theme-sub ck-content">
                        <?=@$title_text;?>
                    </div>
                    <div class="qustion-title">Давайте изучать историю вместе и Хронограф поможет нам в этом.</div>
                    <div class="qustion-blocks">
                        <?=@$questions?>
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
    <script src="/js/conference/chronograph-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
    <?php $this->endSection(); ?>