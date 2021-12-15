<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Результаты командного квеста']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="content-sidebar">
        <h1>Результаты командного квеста</h1>
        <section>
            <div class="grid grid-3 header-grid">
                <div class="row-item">
                    Название команды
                </div>
                <div class="row-item">
                    Количество баллов
                </div>
                <div class="row-item"> </div>
            </div>
            <?=$team_quests;?>
            <div class="grid grid-3 body-grid jq-add" id="jq-add">
                <div class="row-item row-item-dark ajax-title">
                    <input type="text" value="">
                </div>
                <div class="row-item row-item-dark ajax-points">
                    <input type="text" value="">
                </div>
                <div class="row-item row-item-dark">
                    <div class="btns-control">
                        <a class="btn-save btn-save-dark ajax-add" href="#">Добавить</a>
                        <a class="btn-cancel" href="#" style="visibility: hidden;">Удалить</a>
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
    <script src="/js/editor/team-quest-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>