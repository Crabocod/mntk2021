<?php $this->extend('layouts/auth'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Авторизация']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="auth__wrap">
    <div class="-flex -center -justify-center">
        <img class="img-logo" src="/img/logo.png" alt="">
        <div class="logo-text">
            <?=$title_head;?>
        </div>
    </div>
    <div class="auth-form">
        <form action="#" id="auth">
            <input type="hidden" name="conference_id" value="<?=$id;?>">
            <div class="form-row">
                <label for="#">Введите Email</label>
                <input type="email" name="email">
            </div>
            <div class="form-row">
                <label for="#">Введите пароль для входа</label>
                <input type="password" name="password">
                <div class="form-row__alert" id="js-error-message" style="display: none">
                    У Вас нет доступа к этой конференции
                </div>
            </div>
            <div class="form-row">
                <button class="btn-submit">Войти на сайт</button>
                <a class="remember-pass" href="#" data-remodal-target="recovery-pass">Восстановить пароль</a>
            </div>
        </form>
    </div>
</div>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
<script src="/js/jstz.min.js"></script>
<script src="/js/auth-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>
