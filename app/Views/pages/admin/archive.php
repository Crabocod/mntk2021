<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Архив мероприятий - Админ']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/admin/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="news-admin-page ">
    <div class="admin-page">
        <div class="container">
            <div class="admin-wrap">
                <?=view('templates/admin/all/menu');?>
                <div class="admin-content">
                    <h2>Архив мероприятий</h2>

                    <div class="admin-block new-event">
                        <form action="" id="save-archive">
                            <h4>Добавление</h4>
                            <h5>Заголовок</h5>
                            <input type="text" placeholder="Заголовок" name="title" class="required">
                            <h5>Дата, время начала</h5>
                            <div class="new-event_list">
                                <input placeholder="дд.мм.гг." type="date" name="date_from" class="required">
                                <div>в</div>
                                <input placeholder="17:05" type="time" name="time_from" class="required">
                            </div>
                            <h5>Спикер</h5>
                            <input placeholder="ФИО" type="text" name="speaker" class="required">
                            <button class="programs-btn">ДОБАВИТЬ</button>
                        </form>
                    </div>

                    <section class="arhive-table">
                        <div class="grid grid-6 header-grid header-shahmatka-grid-6">
                            <div class="row-item">
                                Обложка
                            </div>
                            <div class="row-item">
                                Дата, время
                            </div>
                            <div class="row-item">
                                Заголовок
                            </div>
                            <div class="row-item">
                                Спикер
                            </div>
                            <div class="row-item">
                                Публиковать
                            </div>
                        </div>
                        <div class="border-table archive-table">

                            <?=$archives ?? '';?>

                        </div>
                    </section>

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
    <script src="/js/admin/archives-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
    <?php $this->endSection(); ?>