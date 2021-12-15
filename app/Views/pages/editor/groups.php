<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Группы участников']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="content-sidebar">
        <h1>Группы участников</h1>
        <section class="groups">
            <div class="grid grid-2 header-grid">
                <div class="row-item">
                    Название группы
                </div>
                <div class="row-item"></div>
            </div>
            <?=@$groups;?>
            <form class="grid grid-2 body-grid" id="add-group">
                <div class="row-item row-item-dark ajax-title">
                    <input type="text" class="required" name="title">
                </div>
                <div class="row-item row-item-dark">
                    <div class="btns-control">
                        <button class="btn-save btn-save-dark ajax-add">Добавить</button>
                        <button class="btn-cancel" style="visibility: hidden;">Удалить</button>
                    </div>
                </div>
            </form>
        </section>
        <section class="section-grey">
            <div class="-flex -center">
                <h2>Участники</h2>
                <button class="btn-distribute-users">Распределить</button>
            </div>
            <table class="table-flex" id="members">
                <tbody>
                    <?=\App\Entities\UserGroup\UserGroupView::getEditorTableHead();?>
                    <?=@$user_groups;?>
                </tbody>
            </table>
        </section>
    </div>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/editor/groups-page.js?v=<?= \Config\SiteVersion::$main; ?>"></script>
<?php $this->endSection(); ?>