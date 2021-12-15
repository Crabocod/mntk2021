<?php $this->extend('layouts/auth'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Авторизация']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="select-conf__wrap">
    <a href="/" class="-flex -center -justify-center">
        <img class="img-logo" src="/img/logo.png" alt="">
    </a>

    <? if (!empty($conferences)) { ?>
        <div class="h2-text">Выберите конференцию для входа</div>
    <? } else { ?>
        <div class="h2-text">Нет конференций для входа</div>
    <? } ?>

    <div class="select-conf__list">
        <?
//        foreach ($conferences as $conference) {
//            echo "<a href= '/" . $conference->url_segment . " '> " . $conference->title . "</a>";
//        }
        ?>
    </div>
</div>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
<script src="/js/auth-page.js"></script>
<?php $this->endSection(); ?>
