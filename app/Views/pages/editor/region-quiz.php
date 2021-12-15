<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Викторина «Узнай регион»']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="content-sidebar">
        <h1>Викторина «Узнай свой регион» </h1>

        <section class="section-grey">
            <form action="" id="save-main">
                <div class="form-row">
                    <label for="#">Текст главного блока</label>
                    <textarea id="region_quiz_text" name="region_quiz_text" rows="50"><?=esc(@$conference['region_quiz_text']);?></textarea>
                </div>
                <div class="form-row">
                    <button class="btn-save btn-save-green btn-submit">Сохранить</button>
                </div>
            </form>
        </section>

        <table class="table-flex table-quiz">
            <tr>
                <th width="130px">Номер вопроса</th>
                <th>
                    <div class="row-item">
                        Текст
                    </div>
                </th>
                <th width="100px">
                    <div class="row-item">
                        Изображение
                    </div>
                </th>
                <th width="100px">
                    <div class="row-item">
                        Аудио
                    </div>
                </th>
                <th width="100px">
                    <div class="row-item">
                    </div>
                </th>
                <th width="100px">
                    <div class="row-item">
                        Публиковать
                    </div>
                </th>
            </tr>
            <?=@$questions_table_rows;?>
            <tr id="add-row">
                <td>
                    <div class="row-item">
                        <input name="number" class="input-nom" type="text" value="">
                    </div>
                </td>
                <td>
                    <div class="row-item row-2-items">
                        <input type="text" name="youtube_iframe" placeholder="Код iframe" style="margin-bottom: 4px; width: 100%">
                        <textarea name="text" class="height-100" placeholder="Текст"></textarea>
                    </div>
                </td>
                <td>
                    <form>
                        <div class="row-item row-image">
                            <div class="thumbnail_div">
                                <input name="img" type="file" class="thumbnail" accept="image/*">
                                <span>Прикрепить изображение</span>
                                <img class="image" src="" alt="" draggable="false" style="display: none">
                            </div>
                            <img class="image__delete" src="/img/delete-krest.svg" style="display: none">
                        </div>
                    </form>
                </td>
                <td>
                    <form action="">
                        <div class="row-item row-audio">
                            <div class="thumbnail_div">
                                <input type="file" name="audio" id="file-add" class="inputfile inputfile-1"
                                       accept="audio/*">
                                <span>Прикрепить аудио</span>
                                <input type="hidden" name="deleted_audio" value="0">
                            </div>
                        </div>
                    </form>
                </td>
                <td>
                    <div class="row-item">
                        <div class="btns-control">
                            <a class="btn-save btn-save-dark" href="#">Добавить</a>
                        </div>
                    </div>
                </td>
                <td>
                </td>
            </tr>
        </table>

        <?if(!empty($answers_table_rows)):?>
        <section class="section-grey">
            <div class="-flex -center">
                <h2>Ответы пользователей</h2>
                <a class="expot-exl" href="#" id="expot-exl">Экспортировать в  Excel</a>
            </div>
            <table class="table-flex">
                <tr>
                    <th width="180px">Имя</th>
                    <th width="210px">
                        <div class="row-item">
                            Почта
                        </div>
                    </th>
                    <th >
                        <div class="row-item">
                            Ответы
                        </div>
                    </th>
                </tr>
                <?=@$answers_table_rows;?>
            </table>
        </section>
        <?endif;?>
    </div>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/ckeditorHtmlEmbed/build/ckeditor.js"></script>
    <script src="/js/editor/region-quiz-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>