<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Обратная связь']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="content-sidebar">
        <h1>Обратная связь </h1>
        <section class="section-grey">
            <form action="" id="save-feedback">
                <div class="form-row form-row-editor">
                    <label for="#">Текст перед ссылкой</label>
                    <textarea class="height-100" name="gf_text" id="gf_text"><?=@$conference['gf_text'];?></textarea>
                </div>
                <div class="form-row">
                    <label for="#">Ссылка на актуальную гугл-форму</label>
                    <input type="text" value="<?=@$conference['gf_url'];?>" name="gf_url">
                </div>
                <div class="form-row">
                    <button class="btn-save btn-save-green btn-submit">Сохранить</button>
                </div>
            </form>
        </section>
        <section class="section-grey">
            <h2>Изображения результатов опросов</h2>
            <div class="admin-photos feedback-photos sortable-images">
                <?=@$feedback_images;?>
                <form class="admin-photos__item disabled">
                    <div class="add-photo">
                        <label for="add-photo">
                            <input id="add-photo" type="file" name="img" accept="image/*">
                            <span>Добавить</span>
                        </label>
                    </div>
                </form>
            </div>
        </section>
    </div>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/ckeditorHtmlEmbed/build/ckeditor.js"></script>
    <script src="/js/editor/feedback-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>