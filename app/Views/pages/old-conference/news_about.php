<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Живая лента']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo view('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

<div class="content">
    <div class="container">
        <a href="/<?= @$url_segments[0]; ?>/news" class="go-back"><- Вернуться назад</a>
        <div class="single__event">
            <div class="single__event__header -flex">
                <div class="single__event__title"><?=@$news->title;?></div>
            </div>
            <div class="single__event__meta -flex">
                <div class="data"><?=@$news->date;?></div>
            </div>
            <div class="single__event__content ck-content">
                <p><?=@$news->full_text;?></p>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
<?php $this->endSection(); ?>
