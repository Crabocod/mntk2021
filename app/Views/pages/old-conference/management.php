<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Углеродный менеджмент']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo view('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

    <div class="content content-management">
        <div class="container">
            <h1><?= @$conferences->management_title; ?></h1>
            <? if (!empty(@$conferences->management_file_url) or !empty($conferences->management_top_text)): ?>
                <div class="index-welcome__logo -flex -center">
                    <div class="content__grey ck-content" style="width: 100%">
                        <? if (!empty($conferences->management_top_text)): ?>
                            <p><?= @$conferences->management_top_text; ?></p>
                            <br>
                        <? endif; ?>
                        <? if (!empty($conferences->management_file_url)): ?>
                            <div class="archive-yellow-bg">
                                <div class="archive__files__list">
                                    <a target="_blank" href="/<?= @$conferences->management_file_url; ?>">
                                        <?= @$conferences->management_file_name; ?>
                                    </a>
                                </div>
                            </div>
                        <? endif; ?>
                    </div>
                </div>
            <? endif; ?>
            <div class="index-welcome__logo -flex -center">
                <div class="content__grey ck-content" style="width: 100%">
                    <p><?= @$conferences->management_text; ?></p>
                </div>
            </div>
            <!--<div class="row single-archive">
                <div class="col-12 mt-30">
                    <div class="grey-bg archive-grey-bg">
                        <h3>Расскажите о ваших впечатлениях</h3>
                        <div class="form-textarea">
                            <form action="#" id="add-feedback">
                                <textarea name="text" placeholder="Оставьте ваш комментарий..."></textarea>
                                <button class="btn-yellow-small btn-submit" type="submit">Отправить</button>
                            </form>
                        </div>

                        <div class="col-articles__list simple-article white-text ck-content" id="section_feedbacks">
                            <?= @$management_feedbacks; ?>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>
    </div>

<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/conference/management-page.js"></script>
<?php $this->endSection(); ?>