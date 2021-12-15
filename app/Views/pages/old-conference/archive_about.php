<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Архив мероприятий']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo view('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

<div class="content">
    <div class="container">
        <a href="/<?= @$url_segments[0]; ?>/archive" class="go-back"><- Вернуться к архиву мероприятий</a>
        <div class="row single-archive">
            <div class="col-8">
                <div class="single__event">
                    <div class="single__event__header -flex">
                        <div class="single__event__title"><?=$archive['title'];?></div>
                    </div>
                    <div class="single__event__content ck-content">
                        <?=$archive['full_text'];?>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="archive-yellow-bg">
                    <h3>Материалы мероприятия</h3>
                    <div class="archive__files__list">
                        <?=@$archive_files;?>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-30">
                <div class="grey-bg archive-grey-bg">
                    <h3>Расскажите о ваших впечатлениях</h3>
                    <div class="form-textarea">
                        <form action="#" id="add-feedback">
                            <textarea name="text" placeholder="Оставьте ваш комментарий..."></textarea>
                            <button class="btn-yellow-small btn-submit" type="submit">Отправить</button>
                        </form>
                    </div>

                    <div class="col-articles__list simple-article white-text" id="section_feedbacks">
                        <?=@$archive_feedbacks;?>
                    </div>
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
<script src="/js/archive-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>
