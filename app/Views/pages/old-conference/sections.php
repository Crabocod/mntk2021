<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Работа секций']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo view('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

<div class="content">
    <div class="container">
        <h1>Работа секций</h1>
        <div class="work-sect__list">
            <?=$sections;?>
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
