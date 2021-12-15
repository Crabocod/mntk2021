<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Знакомство - Админ']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/admin/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="about-page acquaintance">
    <div class="admin-page">
        <div class="container">
            <div class="admin-wrap">
                <?=view('templates/admin/all/menu');?>
                <div class="admin-content">
                    <h2>Знакомство</h2>
                    <div class="admin-block">
                        <div class="admin-block new-event">
                            <form action="" class="znakomstvo-update">
                                <h5>Видео</h5>
                                <input name="youtube_iframe" class="w-100" type="text" placeholder="Код iframe" value="<?=htmlspecialchars(@$znakomstvo['youtube_iframe'])?>">
                                <h5>Заголовок</h5>
                                <input name="title" placeholder="Заголовок" type="text" value="<?=@$znakomstvo['title']?>">
                      
                                
                                <textarea id="znakomstvo_text" name="text" class="full-input textarea-flex" type="text"> <?=@$znakomstvo['text']?> </textarea>
                                <div class="buttons-news">
                                    <button class="programs-btn">Сохранить</button>
                                </div>
                            </form>
                        </div>
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
                            <?if(!empty($feedBack)):?>
                                <?foreach ($feedBack as $item):?>
                                    <div class="row-form">
                                        <div class="row-form_item">
                                            <?=$item['name']?>
                                        </div>
                                        <div class="row-form_item"><?=date('d.m.Y', strtotime($item['created_at']))?></div>
                                        <div class="row-form_item"><?=$item['text']?></div>
                                        <div class="row-form_item">
                                            <div class="ocenka <?=($item['grade'] == 0)?'dis':''?>">
                                                <div class="ocenka-<?=($item['grade'] == 1)?'like':'dislike'?>"></div>
                                            </div>
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
<script src="/js/auth-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<script src="/js/admin/znakomstvo-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>