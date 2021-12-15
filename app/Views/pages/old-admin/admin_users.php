<?php $this->extend('layouts/admin'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Администраторы']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

    <div class="content">
        <div class="container">
            <h1>Администраторы</h1>
            <section class="admin_users">
                <div class="grid grid-4 header-grid">
                    <div class="row-item">
                        Имя
                    </div>
                    <div class="row-item">
                        Фамилия
                    </div>
                    <div class="row-item">
                        Email
                    </div>
                    <div class="row-item"> </div>
                </div>

                    <?=$admin_users;?>
                <div class="grid grid-4 body-grid jq-add">
                    <div class="row-item row-item-dark ajax-name">
                        <input type="text" value="">
                    </div>
                    <div class="row-item row-item-dark ajax-surname">
                        <input type="text" value="">
                    </div>
                    <div class="row-item row-item-dark ajax-email">
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
    <script src="/js/admin/admin-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>