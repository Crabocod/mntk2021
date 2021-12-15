<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Модераторы - Админ']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/admin/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="moderator-page">
    <div class="news-admin-page">
        <div class="admin-page">
            <div class="container">
                <div class="admin-wrap">
                    <?=view('templates/admin/all/menu');?>
                    <div class="admin-content">
                        <form class="excel-form h-f-z">
                            <h2>Модераторы</h2>
                            <input name="import-exl" type="file" id="excel-file" style="display:none;">
                            <button class="btn excel" href="#"><img src="/img/excel.svg">Импортировать из Excel</button>
                            <button type="submit" class="btn add-btn send-all">Отправить пароль всем</button>
                        </form>
                        <section class="users-page">
                            <div class="grid grid-6 header-grid header-shahmatka-grid-6">
                                <div class="row-item">
                                    ФИО
                                </div>
                                <div class="row-item">
                                    E-mail
                                </div>
                                <div class="row-item">
                                    Настройки прав доступа
                                </div>
                            </div>
                            <div class="border-table">

                                <form class="grid grid-6 body-grid shahmatka-grid-6 chess-row add-user user-rows">
                                    <input type="hidden" name="id" value="24">
                                    <div class="row-item">
                                        <input name="full_name" type="text" value="Петоров Иван Иванович">
                                    </div>
                                    <div class="row-item">
                                        <input name="email" type="mail" value="mail@yandex.ru">
                                    </div>
                                    <div class="row-item">
                                        <select class="select">
                                            <option disabled>Выбрать</option>
                                            <option value="HTML">Администратор</option>
                                            <option value="JavaScript">Модератор</option>
                                        </select>
                                    </div>



                                    <div class="row-item">
                                        <div class="btns-control">
                                            <button type="submit" class="btn">Сохранить</button>
                                            <a href="#">
                                                <div class="btn-cancel"></div>
                                            </a>
                                            <a href="#">
                                                <div class="btn-mail"></div>
                                            </a>
                                        </div>
                                    </div>
                                </form>

                                <form class="grid grid-6 body-grid shahmatka-grid-6 chess-row add-user">
                                    <div class="row-item">
                                        <input name="full_name" type="text">
                                    </div>
                                    <div class="row-item">
                                        <input name="email" type="mail" >
                                    </div>
                                    <div class="row-item">
                                        <select name="role_id" class="select">
                                            <option disabled>Выбрать</option>
                                            <option value="1">Администратор</option>
                                            <option value="2">Модератор</option>
                                        </select>
                                    </div>

                                    <div class="row-item">
                                        <div class="btns-control">
                                            <button type="submit" class="btn add-btn">Добавить</button>
                                            <a style="visibility: hidden;" href="#">
                                                <div class="btn-cancel"></div>
                                            </a>
                                            <a style="visibility: hidden;" href="#">
                                                <div class="btn-mail"></div>
                                            </a>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </section>
                    </div>
                </div>
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
<script src="/js/jstz.min.js"></script>
<script src="/js/auth-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<script src="/js/admin/moderators-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>