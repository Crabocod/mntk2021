<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Новости']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="content-sidebar">
        <a class="to-back" href="/editor/<?=$conference['id'];?>/news"><-- Вернуться к живой ленте</a>
        <h1>Редактирование </h1>
        <section class="section-grey">
            <form action="#" id="save-news">
                <input type="hidden" name="id" value="<?=@$news['id'];?>">
                <div class="form-row">
                    <label for="#">Заголовок новости</label>
                    <input type="text" name="title" value="<?=@$news['title'];?>" autocomplete="off" class="required">
                </div>
                <div class="form-row">
                    <label for="#">Дата новости </label>
                    <input type="text" name="date" value="<?=@$news['date'];?>" autocomplete="off" class="required litepicker-date" placeholder="дд.мм.гггг">
                </div>
                <div class="form-row form-row-editor">
                    <label for="#">Краткий текст новости</label>
                    <textarea name="short_text" id="short_text"><?=esc(@$news['short_text']);?></textarea>
                </div>
                <div class="form-row form-row-editor">
                    <label for="#">Полный текст новости</label>
                    <textarea name="full_text" id="full_text"><?=esc(@$news['full_text']);?></textarea>
                </div>
                <div class="form-row">
                    <div class="btns-control">
                        <button type="submit" class="btn-save btn-save-green">Сохранить</button>
                        <a class="btn-cancel" href="#">Удалить</a>
                    </div>
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
    <script src="/js/editor/news-about-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>