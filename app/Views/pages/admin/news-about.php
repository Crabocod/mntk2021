<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Новостная лента - Админ']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/admin/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="news-admin-page">
    <div class="admin-page">
        <div class="container">
            <div class="admin-wrap">
                <?=view('templates/admin/all/menu');?>
                <div class="admin-content">
                    <div class="back-admin">
                        <a href="/admin/news">
                        <div class="arrow"></div>
                         Вернуться к новостям
                        </a>
                    </div>
                    <h2>Редактирование</h2>
                    <div class="admin-block">
                        <form action="" enctype="multipart/form-data" class="add-news">
                            <input type="hidden" name="id" value="<?=$news_info['id']?>">
                            <div class="admin-block_content">
                                <div class="admin-block_content-block">
                                    <h5>Обложка новости</h5>
                                    <label for="file-upload" class="btn"><img src="/img/screpka.svg">
                                    <?=mb_strimwidth($news_info['file_title'], 0, 15, "...")?>
                                    </label>
                                    <input name="img_link" class="invisible" id="file-upload" type="file"  accept="image/*" />
                                </div>

                                <div class="admin-block_content-block">
                                    <h5>Видео</h5>
                                    <input name="iframe" type="text" placeholder="Код iframe" value="<?=htmlspecialchars($news_info['youtube_iframe'])?>">
                                </div>
                            </div>

                            <h5>Дата</h5>
                            <input name="date" type="date" value="<?=$news_info['date']?>">

                            <h5>Название</h5>
                            <input name="title" class="full-input" type="text" placeholder="Обратный отсчет завершился" value="<?=$news_info['title']?>">

                            <h5>Короткий текст</h5>
                            <textarea id="news-textarea" name="text" class="full-input textarea-flex" type="text"
                                placeholder="[редактор текста]"><?=$news_info['short_text']?></textarea>

                            <h5>Полный текст</h5>
                            <textarea id="news-textarea-full" name="full_text" class="full-input textarea-flex" type="text"
                                      placeholder="[редактор текста]"><?=$news_info['full_text']?></textarea>

                            <label class="switch-checkbox">
                            <div class="span-switch"> Отображение новости  на сайте</div>
                                <input name="is_publication" type="checkbox" <?=($news_info['is_publication'])?'checked':''?> >
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
    <script src="/js/admin/news-about-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>