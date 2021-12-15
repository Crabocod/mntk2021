<? $session = session(); ?>

<?php $this->extend('layouts/auth'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Восстановление пароля']); ?>
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
        <form class="auth-block" id="auth">
            <div class="auth-title">
                Восстановление пароля
                <? if(!empty($session->confirm_email)): ?>
                    <div class="confirm-email-message"><?=$session->confirm_email;?></div>
                <?endif;?>
            </div>
            <h5>Введите Email</h5>
            <input type="text" name="email" class="required">
            <button class='auth-btn'>Отправить пароль для восстановления</button>
        </form>
    </div>

<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/jstz.min.js"></script>
    <script src="/js/recovery-page.js?v=<?= \Config\SiteVersion::$main; ?>"></script>
<?php $this->endSection(); ?>