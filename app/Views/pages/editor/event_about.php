<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Информация об ОГ']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

    <div class="content-sidebar">
        <a class="to-back" href="/editor/<?=$conference['id'];?>/events"><-- Вернуться к ближайшим мероприятиям</a>
        <h1>Редактирование </h1>

        <?=$event;?>
    </div>

<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/ckeditorHtmlEmbed/build/ckeditor.js"></script>
    <script src="/js/editor/event-about-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>
