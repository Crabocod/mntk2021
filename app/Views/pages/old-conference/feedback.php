<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Обратная связь']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo view('templates/all/yellow_page_header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

<div class="content">
    <div class="container">
        <a href="/<?=$conferences->url_segment?>" class="go-back"><- Вернуться назад</a>
        <div class="grey-header grey-header-feedback">
            <div class="grey-header__title">Обратная связь</div>
            <div class="ck-content"><?=$conferences->gf_text;?></div>
            <a target="_blank" class="btn-yellow-small" href="<?=$conferences->gf_url;?>">Пройти опрос</a>
        </div>
        <?if(!empty($google_form_imgs)):?>
        <div class="resilt-opr">
            <div class="title">Результаты опросов</div>
            <div class="row google-form-imgs">
                <?=@$google_form_imgs;?>
            </div>
        </div>
        <?endif;?>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
<?php $this->endSection(); ?>
