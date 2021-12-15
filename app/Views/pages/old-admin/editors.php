<?php $this->extend('layouts/admin'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Редакторы']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

    <div class="content">
        <div class="container">
            <h1>Редакторы</h1>
            <section >
                <div class="grid grid-5 header-grid grid-5">
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
                        Доступы
                    </div>
                    <div class="row-item"> </div>
                </div>
                <?=$editors;?>
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
                    <div class="row-item row-item-dark ajax-perm">
                        <select data-placeholder="Выберите доступы" class="chosen-select" multiple tabindex="4" id="chosen-add">
                            <?=$options;?>
                        </select>
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
    </div>

<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/admin/editor-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>