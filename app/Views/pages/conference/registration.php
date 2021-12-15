<?php $this->extend('layouts/auth'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Регистрация']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="auth-page">
    <div class="main-block">
        <div class="logo"></div>
        <div class="main-title">МНТК 2021
            <p>XVI Межрегиональная научно-техническая конференция молодых специалистов ПАО «НК «Роснефть»
            </p>
        </div>
    </div>
    <form class="auth-block">
        <div class="auth-title">
            Регистрация
        </div>
        <h5>Введите ФИО</h5>
        <input type="text" name="full_name" class="required">
        <h5>Введите Email</h5>
        <input type="text" name="email" class="required">
        <h5>Введите номер телефона</h5>
        <input type="text" name="phone" class="MaskedPhone" placeholder="7 (___) ___-__-__">
        <h5>Введите пароль для входа</h5>
        <input type="password" name="password" class="required">
        <h5>Подтвердите пароль</h5>
        <input type="password" name="confirm_password" class="required">
        <button class='auth-btn'>Отправить</button>
        <a class='pas' href="/auth">Авторизация</a>
        <div class="checkbox">
            <input type="checkbox" class="custom-checkbox" id="egames3" value="1" name="chb-confirm-1">
            <label for="egames3"></label>
            <a href="">Я согласен(-на) с обработкой персональных данных</a>
        </div>
    </form>
</div>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
<script src="/js/jstz.min.js"></script>
<script src="/js/registration-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>
