<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Ближайшие мероприятия']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

    <div class="content-sidebar">
        <h1>Ближайшие мероприятия</h1>
        <section>
            <div class="grey-block">
                <h2>Новое мероприятие</h2>
                <div class="a-form">
                    <form action="#" id="event-add">
                        <div class="form-row">
                            <label for="#">Заголовок</label>
                            <input type="text" name="title" required>
                        </div>
                        <div class="form-row">
                            <label for="#">Дата</label>
                            <input name="date" type="text" value="" class="litepicker-date required" placeholder="дд.мм.гггг" autocomplete="off">
                        </div>
                        <div class="form-row">
                            <label for="#">Спикер</label>
                            <input type="text" name="speaker" required>
                        </div>
                        <div class="form-row">
                            <button class="btn-yellow-xl ajax-add">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section>
            <table class="table-flex">
                <tr class="table-head">
                    <th width="120px"></th>
                    <th >
                        <div class="row-item">
                            Дата
                        </div>
                    </th>
                    <th>
                        <div class="row-item">
                            Заголовок
                        </div>
                    </th>
                    <th>
                        <div class="row-item">
                            Спикер
                        </div>
                    </th>
                    <th>
                        <div class="row-item">
                            Участников
                        </div>
                    </th>
                </tr>
                <?=$events;?>
            </table>

        </section>
    </div>

<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/editor/events-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>