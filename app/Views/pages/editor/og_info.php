<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Информация об ОГ']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

    <div class="content-sidebar">
        <h1>Информация об ОГ</h1>
        <section class="section-grey">
            <form action="" id="save-og" enctype="multipart/form-data">
            <div class="form-row" style="display: none">
                <label for="#">Фото</label>
                <div class="yellow-attach">
                    <input type="file" name="og_logo" id="file-1" class="inputfile inputfile-1" accept="image/*">
                    <label for="file-1"> <span><?=(!empty($conference['og_logo_name'])) ? $conference['og_logo_name'] : 'Прикрепить...';?></span></label>
                </div>
            </div>
            <div class="form-row" style="display: none">
                <label for="#">Iframe youtube на видео-приветствие</label>
                <input type="text" name="og_video" value="<?=esc($conference['og_video']);?>">
            </div>
            <div class="form-row form-row-editor">
                <label for="#">Текст</label>
                <textarea id="og_text" name="og_text"><?=esc($conference['og_text']);?></textarea>
            </div>
                <div class="form-row">
                    <button type="submit" class="btn-save-green">Сохранить</button>
                </div>
            </form>
        </section>
    </div>

<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/ckeditorHtmlEmbed/build/ckeditor.js"></script>
    <script src="/js/editor/og-info-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>