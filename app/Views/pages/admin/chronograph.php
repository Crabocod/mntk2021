<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Хронограф - Админ']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/admin/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="chrono">
    <div class="news-admin-page  acquaintance">
        <div class="admin-page">
            <div class="container">
                <div class="admin-wrap">
                    <?=view('templates/admin/all/menu');?>
                    <div class="admin-content">
                        <h2>Хронограф</h2>
                        <div class="admin-block">
                                <form action="" class="text-save">
                                    <h5>Текст главного блока</h5>
                                    <textarea id="text" name="text" class="full-input textarea-flex" type="text"><?=@$chronograph['text']?></textarea>
                                    <div class="buttons-news">
                                        <button class="programs-btn">Сохранить</button>
                                    </div>
                                </form>
                            </div>

                        <h4 class="responce-member">Вопросы</h4>

                        <section class="chronograph-admin">
                            <div class="grid grid-6 header-grid header-shahmatka-grid-6">
                                <div class="row-item">
                                    №
                                </div>
                                <div class="row-item">
                                    Текст
                                </div>
                                <div class="row-item">
                                    Изображение
                                </div>
                                <div class="row-item">
                                    Аудио
                                </div>
                                <div class="row-item">
                                    Файлы
                                </div>
                                <div class="row-item">
                                    Видео вопрос
                                </div>
                                <div class="row-item">
                                    Публиковать
                                </div>
                            </div>
                            <div class="border-table">

                                <form class="row-form question_rows" >
                                    <div class="row-form_item">
                                        <input class="input-chrono" type="text" name="number" value="1">
                                    </div>
                                    <div class="row-form_item">
                                        <textarea name="text" value="Tekst"></textarea></div>
                                    <div class="row-form_item"> <label for="image-upload" class="crhrono-label">
                                            Прикрепить
                                            изображение</label>
                                            <div class="delete-photo"></div>
                                        <input name="img_link" class="invisible" id="image-upload" type="file"
                                            accept="image/*" />
                                    </div>
                                    <div class="row-form_item">
                                        <label for="audio-upload" class="crhrono-label"> Прикрепить аудио</label>
                                        <input name="img_link" class="invisible" id="audio-upload" type="file" />
                                        <div class="delete-photo"></div>
                                    </div>
                                    <div class="row-form_item">
                                        <label for="file-upload" class="crhrono-label"> Прикрепить файлы</label>
                                        <input name="img_link" class="invisible" id="file-upload" type="file" />
                                        <div class="delete-photo"></div>
                                    </div>
                                    <div class="row-form_item">
                                        <input name="page_url" class="required" type="text" value="Код iframe">
                                    </div>
                                    <div class="row-form_item">
                                        <button class="crhono-btn">Сохранить</button>
                                        <button class="crhono-btn">Удалить</button>
                                    </div>
                                    <div class="row-form_item">
                                        <div class="checkbox">
                                            <input type="checkbox" class="custom-checkbox" id="public" value="1"
                                                name="chb-confirm-1">
                                            <label for="public"></label>
                                        </div>
                                    </div>
                                </form>

                                <form class="row-form add-row add-question" enctype="multipart/form-data">
                                    <div class="row-form_item">
                                        <input class="input-chrono" type="text" name="number">
                                    </div>
                                    <div class="row-form_item">  </textarea><textarea name="text"></textarea></div>
                                    <div class="row-form_item"> <label for="image-add-upload" class="crhrono-label">
                                            Прикрепить
                                            изображение</label>
                                        <input name="img_link" class="invisible" id="image-add-upload" type="file" accept="image/*" />
                                    </div>
                                    <div class="row-form_item">
                                        <label for="audio-add-upload" class="crhrono-label"> Прикрепить аудио</label>
                                        <input name="audio_link" class="invisible" id="audio-add-upload" type="file" accept="audio/*" />
                                    </div>
                                    <div class="row-form_item">
                                        <label for="file-add-upload" class="crhrono-label"> Прикрепить файлы</label>
                                        <input name="file_link" class="invisible" id="file-add-upload" type="file" />
                                    </div>
                                    <div class="row-form_item">
                                        <input name="youtube_iframe" class="required" type="text">
                                    </div>
                                    <div class="row-form_item">
                                        <button class="crhono-btn chrono-add">Добавить</button>
                                    </div>
                                    <div class="row-form_item"></div>
                                </form>
                            </div>
                        </section>

                        <h4 class="responce-member">Ответы пользователей</h4>
                        <section class="about-page">
                            <div class="grid grid-6 header-grid header-shahmatka-grid-6">
                                <div class="row-item">
                                    Имя
                                </div>
                                <div class="row-item">
                                Почта
                                </div>
                                <div class="row-item">
                                Ответы
                                </div>
                               
                            </div>
                            <div class="border-table">

                                <?=@$answers?>
<!--                                <div class="row-form">-->
<!--                                    <div class="row-form_item">-->
<!--                                        Иванов Иван Иванович-->
<!--                                    </div>-->
<!--                                    <div class="row-form_item">mail@yandex.ru</div>-->
<!--                                    <div class="row-form_item close clamp-row">Lorem ipsum dolor sit amet, consectetur-->
<!--                                        adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna-->
<!--                                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi-->
<!--                                        ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in-->
<!--                                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint-->
<!--                                        occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim-->
<!--                                        id est laborum.</div>-->
<!--                                    <div class="row-form_item">-->
<!--                                        <div class="uncover"><span>Раскрыть</span><img class="uncover-img"-->
<!--                                                src="/img/uncover.svg"></div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                                <div class="row-form">-->
<!--                                    <div class="row-form_item">-->
<!--                                        Иванов Иван Иванович-->
<!--                                    </div>-->
<!--                                    <div class="row-form_item">mail@yandex.ru</div>-->
<!--                                    <div class="row-form_item close clamp-row">Lorem ipsum dolor sit amet, consectetur-->
<!--                                        adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna-->
<!--                                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi-->
<!--                                        ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in-->
<!--                                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint-->
<!--                                        occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim-->
<!--                                        id est laborum.</div>-->
<!--                                    <div class="row-form_item">-->
<!--                                        <div class="uncover"><span>Раскрыть</span><img class="uncover-img"-->
<!--                                                src="/img/uncover.svg"></div>-->
<!--                                    </div>-->
<!--                                </div>-->

                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('.uncover').click(function() {
    $(this).toggleClass('active')
    $(this).parent().parent().children('.clamp-row').toggleClass('close')
    if ($(this).children('span').text() == 'Раскрыть') {
        $(this).children('span').text('Скрыть')
    } else {
        $(this).children('span').text('Раскрыть')
    }
})
</script>
<?php $this->endSection(); ?>



<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
<script src="/js/jstz.min.js"></script>
<script src="/js/admin/chronograph-page.js"></script>

<?php $this->endSection(); ?>