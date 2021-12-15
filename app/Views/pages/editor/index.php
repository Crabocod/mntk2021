<?php $this->extend('layouts/editor'); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/ckeditorHtmlEmbed/build/ckeditor.js"></script>
    <script src="/js/editor/index-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Конференции']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="content-sidebar">
        <h1>Главная страница</h1>

        <section class="section-grey">
            <form action="" id="save-main">
                <div class="form-row">
                    <label for="#">HTML-код виджета МС-радио</label>
                    <input type="text" name="widget" value="<?=esc($conference['widget']);?>">
                </div>
                <div class="form-row">
                    <label for="#">Текст бегущей строки</label>
                    <textarea name="ticker"><?=esc($conference['ticker']);?></textarea>
                </div>
                <div class="form-row">
                    <button class="btn-save btn-save-green btn-submit">Сохранить</button>
                </div>
            </form>
        </section>

        <section class="section-grey">
            <form action="" id="block-statuses">
                <table class="simple-table">
                    <tbody>
                        <tr class="user_cards">
                            <td>
                                Таймер
                            </td>
                            <td style="width: 150px;">
                                <a class="<?=(@$conference['show_timer_block'] == 1)?'btn-delete':'btn-save';?>" href="#"><?=(@$conference['show_timer_block'] == 1)?'Скрыть':'Показать';?></a>
                                <input type="hidden" name="show_timer_block" value="<?=(@$conference['show_timer_block']);?>">
                            </td>
                        </tr>
                        <tr class="user_cards">
                            <td>
                                Прямой эфир
                            </td>
                            <td style="width: 150px;">
                                <a class="<?=(@$conference['show_ether_block'] == 1)?'btn-delete':'btn-save';?>" href="#"><?=(@$conference['show_ether_block'] == 1)?'Скрыть':'Показать';?></a>
                                <input type="hidden" name="show_ether_block" value="<?=(@$conference['show_ether_block']);?>">
                            </td>
                        </tr>
                        <tr class="user_cards">
                            <td>
                                Приветствие и баррель
                            </td>
                            <td style="width: 150px;">
                                <a class="<?=(@$conference['show_main_block'] == 1)?'btn-delete':'btn-save';?>" href="#"><?=(@$conference['show_main_block'] == 1)?'Скрыть':'Показать';?></a>
                                <input type="hidden" name="show_main_block" value="<?=(@$conference['show_main_block']);?>">
                            </td>
                        </tr>
                        <tr class="user_cards">
                            <td>
                                Ближайшие мероприятия с живой лентой
                            </td>
                            <td style="width: 150px;">
                                <a class="<?=(@$conference['show_eventsnews_block'] == 1)?'btn-delete':'btn-save';?>" href="#"><?=(@$conference['show_eventsnews_block'] == 1)?'Скрыть':'Показать';?></a>
                                <input type="hidden" name="show_eventsnews_block" value="<?=(@$conference['show_eventsnews_block']);?>">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </section>

        <section class="section-grey">
            <form action="" id="timer" enctype="multipart/form-data">
                <h2>Таймер</h2>
                <div class="form-row form-row-editor">
                    <label for="#">Выберите дату и время по вашему часовому поясу</label>
                    <div class="data-time -flex -center">
                        <?$conference['timer_datetime'] = \App\Libraries\DateTime::byUserTimeZone(\App\Entities\Users\UserSession::getUser(), $conference['timer_datetime']);?>
                        <input value="<?=(!empty($conference['timer_datetime'])) ? date('Y-m-d', strtotime($conference['timer_datetime'])) : '';?>" type="text" name="timer_date" autocomplete="off" class="required litepicker-date date" placeholder="дд.мм.гггг">
                        <input value="<?=(!empty($conference['timer_datetime'])) ? date('H:i', strtotime($conference['timer_datetime'])) : '';?>" class="required" type="time" name="timer_time" autocomplete="off">
                    </div>
                </div>
                <div class="form-row">
                    <button class="btn-save btn-save-green btn-submit">Сохранить</button>
                </div>
            </form>
        </section>

        <section class="section-grey">
            <form action="" id="ether_form" enctype="multipart/form-data">
                <h2>Прямой эфир</h2>
                <div class="form-row">
                    <label for="#">Iframe youtube</label>
                    <input class="required" type="text" name="ether_iframe" value="<?=esc($conference['ether_iframe']);?>">
                </div>
                <div class="form-row">
                    <button class="btn-save btn-save-green btn-submit">Сохранить</button>
                </div>
            </form>
        </section>

        <section class="section-grey">
            <form action="" id="save-gr" enctype="multipart/form-data">
                <h2>Приветствие</h2>
                <div class="form-row mt-30" style="display: none">
                    <label for="#">Логотип</label>
                    <div class="yellow-attach">
                        <input type="file" name="gr_logo" id="file-1" class="inputfile inputfile-1" accept="image/*">
                        <label for="file-1"> <span><?=(!empty($conference['gr_logo_name'])) ? $conference['gr_logo_name'] : 'Прикрепить...';?></span></label>
                    </div>
                </div>
                <div class="form-row">
                    <label for="#">Заголовок</label>
                    <input class="required" type="text" name="gr_title" value="<?=esc($conference['gr_title']);?>">
                </div>
                <!--<div class="form-row">
                    <label for="#">Iframe youtube на видео-приветствие</label>
                    <input class="required" type="text" name="gr_video" value="<?=esc($conference['gr_video']);?>">
                </div>-->
                <div class="form-row form-row-editor">
                    <label for="#">Текст</label>
                    <textarea name="gr_text" id="gr_text"><?=esc($conference['gr_text']);?></textarea>
                </div>
                <div class="form-row">
                    <button class="btn-save btn-save-green btn-submit">Сохранить</button>
                </div>
            </form>
        </section>

        <section class="section-grey">
            <h2>Шахматка</h2>
            <section>
                <div class="grid grid-6 header-grid header-shahmatka-grid-6">
                    <div class="row-item">
                        Дата
                    </div>
                    <div class="row-item">
                        Тип мероприятия
                    </div>
                    <div class="row-item">
                        Название
                    </div>
                    <div class="row-item">
                        Ссылка
                    </div>
                    <div class="row-item">
                        Иконка
                    </div>
                    <div class="row-item"></div>
                </div>
                <?=@$chess;?>
                <form class="grid grid-6 body-grid shahmatka-grid-6" id="add-chess">
                    <div class="row-item row-item-date">
                        <input name="date" type="text" value="" class="litepicker-date required" placeholder="дд.мм.гггг" autocomplete="off">
                        <div>в</div>
                        <input class="required" type="time" name="time" autocomplete="off" value="" />
                    </div>
                    <div class="row-item">
                        <input name="type" type="text" value="" class="required">
                    </div>
                    <div class="row-item">
                        <input name="title" type="text" value="" class="required">
                    </div>
                    <div class="row-item">
                        <input name="page_url" type="text" value="" class="required">
                    </div>
                    <div class="row-item add-icon-row">
                        <div class="thumbnail_div">
                            <input name="img_link" type="file" class="thumbnail" accept="image/*">
                            <span>Прикрепить иконку</span>
                            <img class="icon" src="" height="38px" style="display:none;"/>
                            <img class="icon__delete" src="/img/delete-krest.svg" style="display: none">
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

        <section class="section-grey">
            <form action="" id="save-barrels">
                <div class="form-row">
                    <label for="#">Максимальное количество кликов на «БАРРЕЛЬ»</label>
                    <input class="required" type="text" name="barrels_max" value="<?=esc($conference['barrels_max']);?>">
                </div>
                <div class="form-row">
                    <button class="btn-save btn-save-green btn-submit">Сохранить</button>
                </div>
            </form>
        </section>
    </div>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>