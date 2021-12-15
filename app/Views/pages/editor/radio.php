<?php $this->extend('layouts/editor'); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
<script src="/js/ckeditorHtmlEmbed/build/ckeditor.js"></script>
<?php $this->endSection(); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Прямой эфир']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="content-sidebar">
        <h1>Прямой эфир</h1>
        <section class="section-grey">
            <form action="" id="save-radio" enctype="multipart/form-data">
                <div class="form-row">
                    <label for="#">Заголовок</label>
                    <input class="required" type="text" name="radio_title" value="<?=esc($conference['radio_title']);?>">
                </div>
                <div class="form-row">
                    <label for="#">Аудио</label>
                    <div class="yellow-attach">
                        <input type="file" name="radio_audio" id="file-head" class="inputfile inputfile-1 audio_file" accept="audio/*">
                        <label for="file-head">
                            <span><?=(!empty($conference['radio_audio_name'])) ? $conference['radio_audio_name'] : 'Прикрепить...';?></span>
                        </label>
                        <a class="btn-cancel radio-audio-delete" href="#" style="<?=(empty($conference['radio_audio']))?'display: none;':'';?>">Удалить</a>
                        <input type="hidden" name="deleted_audio" value="0">
                    </div>
                </div>
                <div class="form-row">
                    <label for="#">Ссылка на аудио</label>
                    <input type="text" name="radio_iframe" value="<?=esc($conference['radio_iframe']);?>">
                </div>
                <!--<div class="form-row">
                    <label for="#">Период</label>
                    <div class="data-time -flex -center">
                        <input type="time" name="radio_date_from" autocomplete="off" value="<?=(!empty($conference['radio_date_from']))?date('H:i', strtotime(@$conference['radio_date_from'])):'';?>">
                        &nbsp;&nbsp;&nbsp;-&nbsp;
                        <input type="time" name="radio_date_to" autocomplete="off" value="<?=(!empty($conference['radio_date_to']))?date('H:i', strtotime(@$conference['radio_date_to'])):'';?>">
                    </div>
                </div>-->
                <div class="form-row">
                    <button class="btn-save btn-save-green btn-submit">Сохранить</button>
                </div>
            </form>
        </section>

        <section class="section-grey">
            <h2>Главная шахматка</h2>
            <form action="" id="save-main-schedule" enctype="multipart/form-data">
                <div class="form-row">
                    <label for="#">Текст</label>
                    <textarea name="radio_main_schedule_text" id="radio_main_schedule_text" cols="30" rows="10"><?=@$conference['radio_main_schedule_text'];?></textarea>
                </div>
                <div class="form-row">
                    <label style="margin-bottom: 0px">Фото слева</label>
                    <div class="yellow-attach">
                        <input type="file" name="radio_main_schedule_img1" id="radio_main_schedule_img1" class="inputfile inputfile-1" accept="image/*">
                        <label for="radio_main_schedule_img1">
                            <span><?=(!empty($conference['radio_main_schedule_img1'])) ? $conference['radio_main_schedule_img1'] : 'Прикрепить...';?></span>
                        </label>
                        <a class="btn-cancel delete-image-1" href="#" style="<?=(empty($conference['radio_main_schedule_img1']))?'display: none;':'';?>">Удалить</a>
                        <input type="hidden" name="deleted_image_1" value="0">
                    </div>
                </div>
                <div class="form-row">
                    <label style="margin-bottom: 0px">Фото справа</label>
                    <div class="yellow-attach">
                        <input type="file" name="radio_main_schedule_img2" id="radio_main_schedule_img2" class="inputfile inputfile-1" accept="image/*">
                        <label for="radio_main_schedule_img2">
                            <span><?=(!empty($conference['radio_main_schedule_img2'])) ? $conference['radio_main_schedule_img2'] : 'Прикрепить...';?></span>
                        </label>
                        <a class="btn-cancel delete-image-2" href="#" style="<?=(empty($conference['radio_main_schedule_img2']))?'display: none;':'';?>">Удалить</a>
                        <input type="hidden" name="deleted_image_2" value="0">
                    </div>
                </div>
                <div class="form-row">
                    <button class="btn-save btn-save-green btn-submit">Сохранить</button>
                </div>
            </form>
        </section>

        <section class="section-grey">
            <h2>Шахматка</h2>
            <table class="table-flex table-quiz table-radio">
                <tr>
                    <th style="max-width: 100px" width="180px">
                        <div class="row-item">
                            Название
                        </div>
                    </th>
                    <th width="100px">
                        <div class="row-item">
                            Дата
                        </div>
                    </th>
                    <th width="100px">
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
                        </div>
                    </th>
                </tr>
                <?=$schedules;?>
                <tr id="add-row">
                    <td>
                        <div class="row-item">
                            <input type="text" name="title" placeholder="Название" class="required">
                        </div>
                    </td>
                    <td>
                        <div class="row-item row-2-items">
                            <input name="date" type="text" value="" class="litepicker-date required" placeholder="дд.мм.гггг" autocomplete="off">
                            <div class="-flex -center">
                                <input class="required" type="time" name="date_from" autocomplete="off" value="">
                                &nbsp;-&nbsp;
                                <input class="required" type="time" name="date_to" autocomplete="off" value="">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row-item row-2-items">
                            <input type="text" name="speaker" placeholder="Спикер" style="margin-bottom: 4px; width: 100%" class="required">
                            <textarea name="text" class="height-100"></textarea>
                        </div>
                    </td>
                    <td width="100px">
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
                        <div class="row-item">
                            <div class="btns-control">
                                <a class="btn-save btn-save-dark" href="#">Добавить</a>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </section>

        <section class="section-grey">
            <h2>Архив записей</h2>
            <section>
                <div class="grid grid-6 header-grid header-radio_archive-grid-6">
                    <div class="row-item">
                        Дата
                    </div>
                    <div class="row-item">
                        Название
                    </div>
                    <div class="row-item">
                        Спикер
                    </div>
                    <div class="row-item">
                        Текст
                    </div>
                    <div class="row-item">
                        Аудио
                    </div>
                    <div class="row-item"></div>
                </div>
                <?=$archives;?>
                <form class="grid grid-6 body-grid radio_archive-grid-6" id="add-archive">
                    <div class="row-item">
                        <input name="date" type="text" value="" class="litepicker-date required" placeholder="дд.мм.гггг" autocomplete="off">
                    </div>
                    <div class="row-item">
                        <input name="title" type="text" value="" class="required">
                    </div>
                    <div class="row-item">
                        <input name="speaker" type="text" value="" class="required">
                    </div>
                    <div class="row-item">
                        <textarea name="text" class="required"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="yellow-attach">
                            <input type="file" name="audio" id="file-add" class="inputfile inputfile-1 audio_file" accept="audio/*">
                            <label for="file-add" class="attach"> <span>Прикрепить...</span></label>
                            <input type="hidden" name="audio_change" value="1">
                        </div>
                    </div>
                    <div class="row-item">
                        <div class="btns-control">
                            <button type="submit" class="btn-save btn-save-dark">Добавить</button>
                            <a class="btn-cancel" style="visibility: hidden" href="#">Удалить</a>
                        </div>
                    </div>
                </form>
            </section>
        </section>
    </div>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
    <script src="/js/editor/radio-page.js"></script>
<?php $this->endSection(); ?>