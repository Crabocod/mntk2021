<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Архив мероприятий - Админ']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/admin/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="news-admin-page about-page">
    <div class="admin-page">
        <div class="container">
            <div class="admin-wrap">
                <?=view('templates/admin/all/menu');?>
                <div class="admin-content">
                    <a class="back-admin" href="/admin/archive">
                        <div class="arrow"></div> Вернуться к архиву
                    </a>
                    <h2>Редактирование</h2>
                    <div class="admin-block">
                        <form id="update_archive" class="update_archive" action="" enctype="multipart/form-data">
                            <div class="admin-block_content">
                                <div class="admin-block_content-block">
                                    <h5>Изображение превью</h5>
                                    <label for="file-upload" class="btn">
                                        <img src="/img/screpka.svg">
                                        <span><?= $preview_file_title ?? 'Прикрепить'; ?></span>
                                    </label>
                                    <input class="invisible" id="file-upload" type="file" name="preview_file"/>
                                </div>

                                <div class="admin-block_content-block">
                                    <h5>Материалы</h5>
                                    <label for="presentacia" class="btn"><img src="/img/screpka.svg">
                                        <span><?= $presentation_file_title ?? 'Прикрепить'; ?></span>
                                    </label>
                                    <input class="invisible" id="presentacia" type="file" name="presentation_file"/>
                                </div>

                                <div class="admin-block_content-block">
                                    <h5>Видео</h5>
                                    <input type="text" placeholder="Код iframe" name="youtube_iframe"
                                           value="<?= (!empty($youtube_iframe)) ? esc($youtube_iframe) : ''; ?>">
                                </div>

                                <div class="admin-block_content-block">
                                    <h5>Фото</h5>
                                    <label for="speaker" class="btn"><img src="/img/screpka.svg">
                                        <span><?= $photo_file_title ?? 'Прикрепить'; ?></span>
                                    </label>
                                    <input class="invisible" id="speaker" type="file" name="photo_file"/>
                                </div>
                            </div>

                            <div class="admin-block new-event">
                                <h5>Заголовок</h5>
                                <input class="required" type="text" placeholder="Заголовок" name="title"
                                       value="<?= $title ?? ''; ?>">
                                <h5>Дата, время</h5>
                                <div class="new-event_list">
                                    <input class="required" placeholder="дд.мм.гг." type="date" name="date_from"
                                           value="<?= (!empty($date_from)) ? date('Y-m-d', strtotime($date_from)) : ''; ?>">
                                    <div>в</div>
                                    <input class="required" placeholder="17:05" type="time" name="time_from"
                                           value="<?= (!empty($date_from)) ? date('H:i', strtotime($date_from)) : ''; ?>">
                                </div>
                            </div>

                            <!--                        <h5>Название</h5>-->
                            <!--                        <input class="full-input" type="text" placeholder="Обратный отсчет завершился">-->

                            <h5>Короткий текст</h5>
                            <textarea id="short_text" class="full-input textarea-flex not-full" name="short_text"><?= (!empty($short_text)) ? esc($short_text) : ''; ?></textarea>

                            <br>

                            <h5>Текст</h5>
                            <textarea id="full_text" class="full-input textarea-flex" name="full_text"><?= (!empty($full_text)) ? esc($full_text) : ''; ?></textarea>

                            <label class="switch-checkbox">
                                <div class="span-switch"> Отображение новости на сайте</div>
                                <input type="checkbox"
                                       name="is_published" <?= (!empty($is_published)) ? 'checked' : ''; ?>>
                                <span class="slider round"></span>
                            </label>
                            <div class="buttons-news">
                                <button class="programs-btn">Сохранить</button>
                                <a class="news-btn delete-event">Удалить</a>
                            </div>
                        </form>
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
<script src="/js/jstz.min.js"></script>
<script src="/js/admin/archive_about.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>