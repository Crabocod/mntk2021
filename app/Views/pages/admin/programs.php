<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Деловые программы - Админ']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/admin/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="programs-admin">
    <div class="news-admin-page">
        <div class="admin-page">
            <div class="container">
                <div class="admin-wrap">
                    <?=view('templates/admin/all/menu');?>
                    <div class="admin-content">
                        <h2>Деловая программа</h2>
                        <div class="admin-block">
                            <h4>Добавление записи</h4>
                            <form action="" class="add-program">
                                <h5>Обложка церемонии</h5>
                                <label for="file-upload" class="btn m14"><img src="/img/screpka.svg">
                                    Прикрепить
                                </label>
                                <input name="img_link" class="invisible" id="file-upload" type="file" accept="image/*">
                                <h5>Дата создания</h5>
                                <input name="date" type="date">
                                <h5>Код iframe</h5>
                                <input name="iframe" type="text" placeholder="Код iframe ">

                                <h5>Название</h5>
                                <input name="title" class="full-input" type="text" placeholder="Обратный отсчет завершился">

                                <h5>Текст</h5>
                                <textarea id="text" name="text" class="full-input textarea-flex" type="text"></textarea>

                                <button class="programs-btn">Добавить</button>
                            </form>
                        </div>


                        <section class="events-table">
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
                                <div class="row-item">
                                    Публиковать
                                </div>
                            </div>
                            <div class="border-table">

                                <div class="row-form">
                                    <div class="row-form_item">
                                        <img src="/img/programs.jpg" alt="">
                                    </div>

                                    <div class="row-form_item">Очень длинное назване важной новости в этом году</div>
                                    <div class="row-form_item lines">Обратный отсчет завершился и XVI Межрегиональной
                                        научно-технической конференции Обратный отсчет завершился и XVI Межрегиональной
                                        научно-технической конференции...</div>
                                    <div class="row-form_item">
                                        <div class="checkbox">
                                            <input type="checkbox" class="custom-checkbox" id="public" value="1"
                                                name="chb-confirm-1">
                                            <label for="public"></label>
                                        </div>
                                    </div>
                                    <div class="row-form_item">
                                        <div class="btn-cancel"></div>
                                    </div>
                                </div>

                                <div class="row-form">
                                    <div class="row-form_item">
                                        <img src="/img/programs.jpg" alt="">
                                    </div>

                                    <div class="row-form_item">Очень длинное назване важной новости в этом году</div>
                                    <div class="row-form_item lines">Обратный отсчет завершился и XVI Межрегиональной
                                        научно-технической конференции Обратный отсчет завершился и XVI Межрегиональной
                                        научно-технической конференции...</div>
                                    <div class="row-form_item">
                                        <div class="checkbox">
                                            <input type="checkbox" class="custom-checkbox" id="public-1" value="1"
                                                name="chb-confirm-1">
                                            <label for="public-1"></label>
                                        </div>
                                    </div>
                                    <div class="row-form_item">
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
</div>
<?php $this->endSection(); ?>



<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
<script src="/js/jstz.min.js"></script>
<script src="/js/admin/programs-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>