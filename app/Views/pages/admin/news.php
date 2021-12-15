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
                    <h2>Лента новостей</h2>
                    <div class="admin-block">
                        <h4>Добавление записи</h4>
                        <form action="" enctype="multipart/form-data" class="add-news">

                        <div class="admin-block_content">
                            <div class="admin-block_content-block">
                                <h5>Обложка новости</h5>
                                <label for="file-upload" class="btn"><img src="/img/screpka.svg">
                                Прикрепить
                                </label>
                                <input name="img_link" class="invisible" id="file-upload" type="file" accept="image/*"/>
                            </div>
                            <div class="admin-block_content-block">
                                <h5>Видео</h5>
                                <input name="iframe" type="text" placeholder="Код iframe ">
                            </div>
                            </div>
                            <h5>Дата</h5>
                            <input name="date" type="date">

                            <h5>Название</h5>
                            <input name="title" class="full-input" type="text" placeholder="Обратный отсчет завершился">

                            <h5>Короткий текст</h5>
                            <textarea id="news-textarea" name="text" class="full-input textarea-flex" type="text"></textarea>


                            <button class="programs-btn">Добавить</button>
                        </form>
                    </div>


                    <section id="news">
                        <div class="grid grid-6 header-grid header-shahmatka-grid-6">
                            <div class="row-item">
                                Обложка
                            </div>
                            <div class="row-item">
                                Название
                            </div>
                            <div class="row-item">
                                Текст
                            </div>
                        </div>
                        <div class="border-table">

                            <div class="row-form">
                                <div class="row-form_item">
                                    <img src="/img/programs.jpg" alt="">
                                </div>

                                <div class="row-form_item">Очень длинное назване важной новости в этом году</div>
                                <div class="row-form_item">Обратный отсчет завершился и XVI Межрегиональной
                                    научно-технической конференции Обратный отсчет завершился и XVI Межрегиональной
                                    научно-технической конференции...</div>
                                <div class="row-form_item row-buttons">
                                    <div class="row-buttons_edit"></div>
                                    <div class="btn-cancel"></div>
                                </div>
                            </div>

                            <div class="row-form">
                                <div class="row-form_item">
                                    <img src="/img/programs.jpg" alt="">
                                </div>

                                <div class="row-form_item">Очень длинное назване важной новости в этом году</div>
                                <div class="row-form_item">Обратный отсчет завершился и XVI Межрегиональной
                                    научно-технической конференции Обратный отсчет завершился и XVI Межрегиональной
                                    научно-технической конференции...</div>
                                <div class="row-form_item row-buttons">
                                    <div class="row-buttons_edit"></div>
                                    <div class="btn-cancel"></div>
                                </div>
                            </div>

                        </div>
                    </section>
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
<script src="/js/auth-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<script src="/js/admin/news-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>