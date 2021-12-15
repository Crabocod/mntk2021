<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Информация об ОГ']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo view('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

<div class="content">
    <div class="container">
        <h1>Информация об ОГ</h1>
        <div class="index-welcome__logo -flex -center">
            <div class="content__grey ck-content">
                <p><?=$conferences->og_text;?></p>
            </div>
        </div>

<!--        <div class="index-welcome__logo -flex -center">-->
<!--            --><?//if(!empty($conferences->og_logo)):?>
<!--            <img src="/--><?//=$conferences->og_logo;?><!--" alt="">-->
<!--            --><?//endif;?>
<!--            <div class="logo-text">--><?//=$conferences->title;?><!--</div>-->
<!--        </div>-->
<!--        <div class="row ">-->
<!--            <div class="col-7">-->
<!--                <div class="video-frame">-->
<!--                    --><?//=$conferences->og_video;?>
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-5">-->
<!--                <div class="content__grey ck-content">-->
<!--                    <p>--><?//=$conferences->og_text;?><!--</p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
<?php $this->endSection(); ?>
