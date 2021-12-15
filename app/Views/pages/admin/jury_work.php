<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Работа жюри - Админ']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/admin/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="admin-jury">
    <div class="admin-page">
        <div class="container">
            <div class="admin-wrap">
                <?=view('templates/admin/all/menu');?>
                <div class="admin-content">
                    <h2>Работа жюри</h2>
                    <div class="admin-block new-event">
                        <form action="" id="add-jury-work">
                            <h4>Новое мероприятие</h4>
                            <h5>Номер</h5>
                            <input type="number" placeholder="Заголовок" name="number">
                            <h5>Название</h5>
                            <input placeholder="Название" type="text" name="title">
                            <h5>Дата защиты</h5>
                            <div class="new-event_list">
                                <input placeholder="дд.мм.гг." name="date_from" type="date" class="required">
                                <div>в</div>
                                <input placeholder="17:05" name="time_from" type="time" class="required">
                            </div>
                            <button class="programs-btn">ДОБАВИТЬ</button>
                        </form>
                    </div>

                    <section>
                        <div class="grid grid-6 header-grid header-shahmatka-grid-6">
                            <div class="row-item">
                             Номер
                            </div>
                            <div class="row-item">
                              Обложка
                            </div>
                            <div class="row-item">
                               Название
                            </div>
                            <div class="row-item">
                              Дата защиты
                            </div>
                            <div class="row-item">
                             Жюри
                            </div>
                            <div class="row-item">
                             Участники
                            </div>
                        </div>
                        <div class="border-table">

                            <?=@$sections?>
<!--                            <div class="row-form">-->
<!--                            <div class="row-form_item">1</div>-->
<!--                                <div class="row-form_item">-->
<!--                                    <img src="/img/programs.jpg" alt="">-->
<!--                                </div>-->
<!--                                <div class="row-form_item">Очень-очень важное и нужное мероприятие в этом году</div>-->
<!---->
<!--                                <div class="row-form_item">04.11.2021<br>18:30</div>-->
<!--                                <div class="row-form_item">-->
<!--                                Всего: 8-->
<!--                                </div>-->
<!--                                <div class="row-form_item members">-->
<!--                                    Всего: 54-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                    </section>

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
<script src="/js/admin/jury-work-page.js?v=<?= \Config\SiteVersion::$main; ?>"></script>
<?php $this->endSection(); ?>