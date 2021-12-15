<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Хочу стать участником...']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo view('templates/all/yellow_page_header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

<div class="content">
    <div class="container">
        <a href="/<?=$conferences->url_segment?>" class="go-back"><- Вернуться назад</a>
        <div class="yellow-header yellow-header-partner">
            <div class="yellow-header__title">Хочу стать участником...</div>
            <div class="ck-content"><?=@$conferences->wtb_text;?></div>
        </div>
        <div class="grid-3">
            <?=@$member_groups;?>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
<script src="/js/conference/member-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>
