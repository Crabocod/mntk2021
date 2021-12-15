<? $session = session(); ?>

<?php $this->extend('layouts/auth'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Авторизация']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="auth-page auth-admin-page">
        <div class="main-block">
            <div class="logo"></div>
            <div class="main-title">МНТК 2021
                <p>XVI Межрегиональная научно-техническая конференция молодых специалистов ПАО «НК «Роснефть»
                </p>
            </div>
        </div>
        <form class="auth-block" id="auth">
            <div class="auth-title">
                Авторизация
                <? if(!empty($session->confirm_email)): ?>
                    <div class="confirm-email-message"><?=$session->confirm_email;?></div>
                <?endif;?>
                <? if(!empty($session->password_recovery)): ?>
                    <div class="password-recovery-message"><?=$session->password_recovery;?></div>
                <?endif;?>
            </div>
            <h5>Введите Email</h5>
            <input type="text" name="email" class="required">
            <h5>Введите пароль для входа</h5>
            <input type="password" name="password" class="required">
            <button class='auth-btn'>Войти на сайт</button>

            <a class='pas' href="/recovery">Забыли пароль?</a>
        </form>
    </div>

<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/jstz.min.js"></script>
    <script src="/js/admin/auth-page.js?v=<?= \Config\SiteVersion::$main; ?>"></script>
<?php $this->endSection(); ?>