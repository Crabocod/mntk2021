<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Новости']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="content-sidebar">
        <h1>Работа секций</h1>
        <section>
            <div class="grey-block">
                <h2>Новая секция</h2>
                <div class="a-form">
                    <form action="#" id="add_section">
                        <div class="form-row">
                            <label for="#">Номер секции</label>
                            <input type="text" name="title_1" class="required">
                        </div>
                        <div class="form-row">
                            <label for="#">Наименование</label>
                            <input type="text" name="title_2" class="required">
                        </div>
                        <div class="form-row">
                            <label for="#">Дата</label>
                            <input  type="text" name="protection_date" autocomplete="off" class="required litepicker-date" placeholder="дд.мм.гггг">
                        </div>
                        <div class="form-row">
                            <button class="btn-yellow-xl btn-submit">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section>
            <table class="table-flex" id="sectons">
                <tr class="tr-head">
                    <th width="120px">Номер секции</th>
                    <th >
                        <div class="row-item">
                            Наименование
                        </div>
                    </th>
                    <th>
                        <div class="row-item">
                            Дата
                        </div>
                    </th>
                    <th>
                        <div class="row-item">
                            Время начала
                        </div>
                    </th>
                    <th>
                        <div class="row-item">
                            Публиковать?
                        </div>
                    </th>
                </tr>
                <?=@$sections;?>
            </table>
        </section>
    </div>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/editor/sections-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>