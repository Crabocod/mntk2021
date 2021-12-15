<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Пользователи']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="content-sidebar">
        <div class="-flex -center import-exl-form" id="add-users-from-excel">
            <h1>Пользователи</h1>
            <form>
                <input type="file" name="import-exl" id="import-exl-1" accept=".xlsx, .xls, .csv" style="display: none">
                <label for="import-exl-1" class="import-exl" href="#">Импортировать из Excel</label>
            </form>
            <form>
                <label class="send-all-pass" href="#">Отправить пароль всем</label>
            </form>
        </div>
        <section class="users-list">
            <div class="grid grid-5 header-grid">
                <div class="row-item">
                    Имя
                </div>
                <div class="row-item">
                    Фамилия
                </div>
                <div class="row-item">
                    Email
                </div>
                <div class="row-item">
                    Название ОГ
                </div>
                <div class="row-item"> </div>
            </div>
            <?=$users;?>
            <div class="grid grid-5 body-grid jq-add">
                <div class="row-item row-item-dark ajax-name">
                    <input type="text" value="">
                </div>
                <div class="row-item row-item-dark ajax-surname">
                    <input type="text" value="">
                </div>
                <div class="row-item row-item-dark ajax-email">
                    <input type="text" value="">
                </div>
                <div class="row-item row-item-dark ajax-og">
                    <input type="text" value="">
                </div>
                <div class="row-item row-item-dark">
                    <div class="btns-control">
                        <a class="btn-save btn-save-dark ajax-add" href="#">Добавить</a>
                        <a class="btn-cancel" href="#" style="visibility: hidden;">Удалить</a>
                        <a class="send-pass" href="#" style="visibility: hidden;"></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/editor/users-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>