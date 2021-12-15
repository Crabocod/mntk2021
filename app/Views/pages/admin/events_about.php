<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => $title ?? '']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/admin/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="news-admin-page about-page">
        <div class="admin-page">
            <div class="container">
                <div class="admin-wrap">
                    <?= view('templates/admin/all/menu'); ?>
                    <div class="admin-content">
                        <a class="back-admin" href="/admin/<?= $url_segment ?? ''; ?>">
                            <div class="arrow"></div>
                            Вернуться назад
                        </a>
                        <h2>Редактирование</h2>
                        <div class="admin-block">
                            <form id="update_event" action="" enctype="multipart/form-data">
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
                                        <h5>Презентация</h5>
                                        <label for="presentacia" class="btn"><img src="/img/screpka.svg">
                                            <span><?= $presentation_file_title ?? 'Прикрепить'; ?></span>
                                        </label>
                                        <input class="invisible" id="presentacia" type="file" name="presentation_file"/>
                                    </div>

                                    <div class="admin-block_content-block">
                                        <h5>Фото спикера</h5>
                                        <label for="speaker" class="btn"><img src="/img/screpka.svg">
                                            <span><?= $photo_file_title ?? 'Прикрепить'; ?></span>
                                        </label>
                                        <input class="invisible" id="speaker" type="file" name="photo_file"/>
                                    </div>

                                    <div class="admin-block_content-block">
                                        <h5>Видео мастер-класса</h5>
                                        <input type="text" placeholder="Код iframe" name="youtube_iframe"
                                               value="<?= (!empty($youtube_iframe)) ? esc($youtube_iframe) : ''; ?>">
                                    </div>
                                </div>

                                <div class="admin-block new-event">
                                        <h5>Заголовок</h5>
                                        <input class="required" type="text" placeholder="Заголовок" name="title"
                                               value="<?= $title ?? ''; ?>">
                                        <h5>Дата, время начала</h5>
                                        <div class="new-event_list">
                                            <input class="required" placeholder="дд.мм.гг." type="date" name="date_from"
                                                   value="<?= (!empty($date_from)) ? date('Y-m-d', strtotime($date_from)) : ''; ?>">
                                            <div>в</div>
                                            <input class="required" placeholder="17:05" type="time" name="time_from"
                                                   value="<?= (!empty($date_from)) ? date('H:i', strtotime($date_from)) : ''; ?>">
                                        </div>
                                        <h5>Дата, время окончания</h5>
                                        <div class="new-event_list">
                                            <input class="required" placeholder="дд.мм.гг." type="date" name="date_to"
                                                   value="<?= (!empty($date_to)) ? date('Y-m-d', strtotime($date_to)) : ''; ?>">
                                            <div>в</div>
                                            <input class="required" placeholder="17:05" type="time" name="time_to"
                                                   value="<?= (!empty($date_to)) ? date('H:i', strtotime($date_to)) : ''; ?>">
                                        </div>
                                </div>

                                <!--                        <h5>Название</h5>-->
                                <!--                        <input class="full-input" type="text" placeholder="Обратный отсчет завершился">-->

                                <h5>Спикер</h5>
                                <input class="required" placeholder="ФИО" type="text" value="<?= $speaker ?? ''; ?>" name="speaker">

                                <h5>О спикере</h5>
                                <textarea id="about_speaker" class="full-input textarea-flex not-full" name="about_speaker"><?= (!empty($about_speaker)) ? esc($about_speaker) : ''; ?></textarea>

                                <br>
                                <h5>Текст</h5>
                                <textarea id="full_text" class="full-input textarea-flex" name="full_text"><?= (!empty($full_text)) ? esc($full_text) : ''; ?></textarea>

                                <label class="switch-checkbox">
                                    <div class="span-switch"> Отображение новости на сайте</div>
                                    <input type="checkbox"
                                           name="show_button" <?= (!empty($show_button)) ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                                <div class="buttons-news">
                                    <button class="programs-btn">Сохранить</button>
                                    <a class="news-btn delete-event">Удалить</a>
                                </div>
                            </form>
                        </div>

                        <div class="admin-block">
                            <form id="update_enent_user">
                                <div class="h-f-z">
                                    <h4>Участники</h4>
                                </div>
                                <?if(!empty($users)):?>
                                    <?foreach ($users as $user):?>
                                    <?if($user instanceof \CodeIgniter\Entity) $user = $user->toRawArray(); ?>
                                        <div class="member-row" user_id="<?=$user['user_id'] ?? '';?>"><img src="/img/member.svg"><?=$user['user_full_name'] ?? '';?> (<?=$user['user_email'] ?? '';?>)
                                            <button class="member-btn js-allow-user" style="<?=($user['status'] == '1') ? 'display:none': '';?>">Разрешить</button>
                                            <button class="member-btn js-disallow-user" style="<?=($user['status'] == '2') ? 'display:none': '';?>">Отклонить</button>
                                        </div>
                                    <?endforeach;?>
                                <?endif;?>
                            </form>
                        </div>

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

                        <h4 class="responce-member">Отзывы участников</h4>

                        <section>
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
    <script src="/js/admin/events-about-page.js?v=<?= \Config\SiteVersion::$main; ?>"></script>
<?php $this->endSection(); ?>