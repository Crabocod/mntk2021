<?php $this->extend('layouts/admin'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Конференции']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="run-text__content">
        <marquee behavior="scroll" direction="left"><?= @$conferences->ticker; ?></marquee>
    </div>

    <div class="content">
        <div class="container">
            <h1>Конференции</h1>
            <section id="conferences" class="admin-conferences">
                <div class="grid grid-5 header-grid conference-header-grid">
                    <div class="row-item">
                        Наименование
                    </div>
                    <div class="row-item">
                        Наименование в шапке сайта
                    </div>
                    <div class="row-item">
                        Ссылка
                    </div>
                    <div class="row-item">
                        Ключ API
                    </div>
                    <div class="row-item"></div>
                </div>
                <?=@$table_rows;?>
            </section>

            <section class="mt-50">
                <div class="grey-block">
                    <h2>Новая конференция</h2>
                    <div class="a-form">
                        <form action="/admin/save-conference" id="save-conference" method="post">
                            <div class="form-row">
                                <label for="#">Введите наименование</label>
                                <textarea name="title" rows="3"></textarea>
                            </div>
                            <div class="form-row">
                                <label for="#">Наименование в шапке сайта</label>
                                <textarea name="title_head" rows="3"></textarea>
                            </div>
                            <div class="form-row">
                                <label for="#">Введите ссылку</label>
                                <input type="text" name="url_segment">
                            </div>
                            <div class="form-row">
                                <label for="#">Ключ API</label>
                                <input type="text" name="eventicious_api_key">
                            </div>
                            <div class="form-row">
                                <button class="btn-yellow-xl btn-submit">Добавить</button>
                            </div>
                        </form>
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
    <script src="/js/admin/index-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>