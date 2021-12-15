<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Архив мероприятий']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="content-sidebar">
        <h1>Архив мероприятий </h1>
        <section>
            <div class="grey-block">
                <h2>Новое мероприятие</h2>
                <div class="a-form">
                    <form action="#" id="add_archive">
                        <div class="form-row">
                            <label for="#">Заголовок</label>
                            <input type="text" name="title" class="required" autocomplete="off">
                        </div>
                        <div class="form-row">
                            <label for="#">Дата</label>
                            <input type="text" name="date" class="litepicker-date required" autocomplete="off" placeholder="дд.мм.гггг">
                        </div>
                        <div class="form-row">
                            <button class="btn-yellow-xl btn-submit">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section>
            <table class="table-flex">
                <tbody id="archives">
                <tr class="tr-head">
                    <th width="180px">Дата</th>
                    <th >
                        <div class="row-item">
                            Заголовок
                        </div>
                    </th>
                </tr>
                <?=@$archives;?>
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
    <script src="/js/editor/archives-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>