<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Архив мероприятий']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo view('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

<div class="content">
    <div class="container">
        <h1>Архив мероприятий</h1>
        <div class="h1-after-text">
            Здесь вы можете найти материалы общедоступных мероприятий <br>
            и мастер-классов, в которых вы участвовали.
        </div>
        <div class="archive__list">
            <?=$archive;?>
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
