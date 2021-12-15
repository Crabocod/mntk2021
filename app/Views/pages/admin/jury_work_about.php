<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Работа жюри - Админ']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/admin/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="news-admin-page about-jury about-page">
    <div class="admin-page">
        <div class="container">
            <div class="admin-wrap">
                <?=view('templates/admin/all/menu');?>
                <div class="admin-content">
                    <div class="back-admin">
                        <a href="/admin/jury-work"> <div class="arrow"></div> Вернуться к секциям</a>
                    </div>
                    <h2>Редактирование</h2>
                    <div class="admin-block">
                        <form action="" enctype="multipart/form-data" id="update_section">
                            <input type="hidden" name="id" value="<?=@$id?>">
                            <div class="admin-block_content">
                                <div class="admin-block_content-block">
                                    <h5>Обложка новости</h5>
                                    <label for="file-upload" class="btn"><img src="/img/screpka.svg">
                                        <span><?= $preview_file_title ?? 'Прикрепить'; ?></span>
                                    </label>
                                    <input name="preview_file" class="invisible" id="file-upload" type="file"
                                        accept="image/*" />
                                </div>

                                <div class="admin-block_content-block">
                                    <h5>Видео</h5>
                                    <input name="youtube_iframe" type="text" placeholder="youtube_iframe"
                                        value="<?= (!empty($youtube_iframe)) ? esc($youtube_iframe) : ''; ?>">
                                </div>
                            </div>

                            <div class="admin-block new-event">
                                <h5>Дата защиты</h5>
                                <div class="new-event_list">
                                    <input class="required" placeholder="дд.мм.гг." type="date" name="date_from"
                                           value="<?= (!empty($protection_date)) ? date('Y-m-d', strtotime($protection_date)) : ''; ?>">
                                    <div>в</div>
                                    <input class="required" placeholder="17:05" type="time" name="time_from"
                                           value="<?= (!empty($protection_date)) ? date('H:i', strtotime($protection_date)) : ''; ?>">
                                </div>

                                <h5>Номер</h5>
                                <input name="number" class="full-input" type="number" placeholder="Номер"
                                    value="<?=(!empty($number)) ? intval($number) : ''?>">

                                <h5>Название</h5>
                                <input name="title" class="full-input" type="text" placeholder="Обратный отсчет завершился"
                                    value="<?=@$title?>">
                            </div>
                            <label class="switch-checkbox">
                                <div class="span-switch"> Отображение новости на сайте</div>
                                <input name="is_publication" type="checkbox"
                                    <?= ($is_publication == 1) ? 'checked' : ''; ?>>
                                <span class="slider round"></span>
                            </label>
                            <div class="buttons-news">
                                <button type="submit" class="programs-btn">Сохранить</button>
                                <a class="news-btn js-delete">Удалить</a>
                            </div>
                        </form>
                    </div>

                    <?if(!empty($users)):?>
                    <div class="h-f-z">
                        <h4>Участники</h4>
                    </div>

                    <section class="col-3 jury">
                    <div class="jury-about_table">
                            <div class="row-item">ФИО</div>
                            <div class="row-item">Телефон</div>
                            <div class="row-item"> E-mail</div>
                            <div class="row-item"> Общество группы</div>
                        </div>
                        <div class="border-table">
                            <?foreach ($users as $user):?>
                            <form class="row-form">
                                <div class="row-form_item"><?=@$user['full_name']?></div>
                                <div class="row-form_item"><?=@$user['phone']?></div>
                                <div class="row-form_item"><?=@$user['email']?></div>
                                <div class="row-form_item"><?=@$user['og_title']?></div>
                            </form>
                            <?endforeach;?>
                    </section>
                    <?endif;?>

                    <div class="h-f-z">
                        <h4>Жюри</h4>
                    </div>

                    <section class="col-3 jury-add">
                        <div class="grid grid-6 header-grid header-shahmatka-grid-6">
                            <div class="row-item">
                                ФИО
                            </div>
                            
                        </div>
                        <div class="border-table jury-table">
                            <?foreach ($jury as $item):?>
                            <form class="row-form save-jury">
                                <input type="hidden" name="id" value="<?=@$item['id']?>">
                                <div class="row-form_item"><input name="speaker" type="text" value="<?=@$item['speaker']?>"></div>
                                <div class="row-form_item">
                                    <button class="crhono-btn">Сохранить</button>
                                    <button class="crhono-btn delete-jury">Удалить</button>
                                </div>
                            </form>
                            <?endforeach;?>
                            <form action="" class="add-jury">
                                <div class="row-form">
                                <div class="row-form_item"><input name="speaker" type="text" value="Александр Сергеевич Пушкин"></div>
                                    <div class="row-form_item">
                                        <button class="crhono-btn chrono-add">Добавить</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </section>

                    <div class="h-f-z">
                        <h4>Фотогалерея</h4>
                    </div>

                    <div class="admin-block">
                        <form class="admin-photo-blocks sortable-images" enctype="multipart/form-data">
                            <?if(!empty($gallery)):?>
                                <?foreach ($gallery as $image):?>
                                    <div data-id="<?=$image['id'] ?? '';?>" class="admin-photo-block"><img src="/<?=(!empty($image['photo_min_file_link']) ? $image['photo_min_file_link'] : ($image['photo_file_link'] ?? ''));?>"><div class=delete-photo></div></div>
                                <?endforeach;?>
                            <?endif;?>
                            <label for="add-photo" class="photo-add disabled"><input id="add-photo" type="file" class="invisible" name="img"><img src="/img/add-photo.svg"></label>
                        </form>
                    </div>

                    <div class="h-f-z">
                        <h4>Отзывы участников</h4>
                    </div>

                    <section class="about-page">
                        <div class="grid grid-6 header-grid header-shahmatka-grid-6">
                            <div class="row-item">
                                Имя
                            </div>
                            <div class="row-item">
                                Дата
                            </div>
                            <div class="row-item">
                                Текст
                            </div>
                            <div class="row-item">
                                Оценка
                            </div>
                        </div>
                        <div class="border-table">
                            
<!--                            <div class="row-form">-->
<!--                                <div class="row-form_item">-->
<!--                                    Иванов Иван Иванович-->
<!--                                </div>-->
<!--                                <div class="row-form_item">01.01.2021</div>-->
<!--                                <div class="row-form_item">Было круто! мне очень понравилось. Много интересной и-->
<!--                                    полезной информации. Было круто! мне очень понравилось. Много интересной и полезной-->
<!--                                    информации.</div>-->
<!--                                <div class="row-form_item">-->
<!--                                    <div class="ocenka">-->
<!--                                        <div class="ocenka-like"></div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

                            <?if(!empty($feedbacks)):?>
                                <?foreach ($feedbacks as $feedback): ?>
                                    <div class="row-form">
                                        <div class="row-form_item">
                                            <?=$feedback['user_full_name'] ?? '';?>
                                        </div>
                                        <div class="row-form_item"><?=(!empty($feedback['created_at'])) ? date('d.m.Y', strtotime($feedback['created_at'])) : '';?></div>
                                        <div class="row-form_item"><?=$feedback['text'] ?? '';?></div>
                                        <div class="row-form_item">

                                            <?if(!empty($feedback['grade'])):?>
                                                <div class="ocenka <?=($feedback['grade'] == 2) ? 'dis' : '';?>">
                                                    <div class="<?=($feedback['grade'] == 1) ? 'ocenka-like' : (($feedback['grade'] == 2) ? 'ocenka-dislike' : '');?>"></div>
                                                </div>
                                            <?endif;?>
                                        </div>
                                    </div>
                                <?endforeach;?>
                            <?endif;?>

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
<script src="/js/admin/jury-work-about-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>