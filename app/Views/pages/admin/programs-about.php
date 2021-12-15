<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Деловые программы - Админ']); ?>
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
                    <div class="back-admin">
                        <a href="/admin/programs"><div class="arrow"></div> Вернуться к списку записей</a>
                    </div>
                    <h2>Редактирование</h2>
                    <div class="admin-block">
                        <form action="" enctype="multipart/form-data" class="add-program">
                            <input type="hidden" name="id" value="<?=$program_info['id']?>">
                            <h5>Обложка церемонии</h5>
                            <label for="file-upload" class="btn m14"><img src="/img/screpka.svg">
                                <?=mb_strimwidth($program_info['file_title'], 0, 15, "...")?>
                                </label>
                                <input name="img_link" class="invisible" id="file-upload" type="file" accept="image/*">


                            <h5>Видео</h5>
                            <input name="iframe" type="text" placeholder="Код iframe" value="<?=htmlspecialchars($program_info['youtube_iframe'])?>">

                            <h5>Дата создания</h5>
                            <input name="date" type="date" value="<?=$program_info['date']?>">

                            <h5>Название</h5>
                            <input name="title" class="full-input" type="text" placeholder="Обратный отсчет завершился" value="<?=$program_info['title']?>">

                            <h5>Текст</h5>
                            <textarea name="text" class="full-input textarea-flex" type="text"
                                      id="text"><?=$program_info['text']?></textarea>
                            <label class="switch-checkbox">
                                <div class="span-switch"> Отображение новости  на сайте</div>
                                <input name="is_publication" type="checkbox" <?=($program_info['is_published'])?'checked':''?> >
                                <span class="slider round"></span>
                            </label>
                            <div class="buttons-news">
                                <button type="submit" class="programs-btn">Сохранить</button>
                                <a class="news-btn js-delete">Удалить</a>
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
<script src="/js/admin/program-about-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>