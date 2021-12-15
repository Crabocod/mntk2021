<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Работа секций']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo view('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

<div class="content">
    <div class="container">
        <a href="/<?=$url_segments[0];?>/sections" class="go-back"><- Вернуться назад</a>
        <div class="single__event mb-30">
            <div class="single__event__header -flex">
                <div class="single__event__title"><?=@$section['title_1'];?> <span><?=@$section['title_2'];?></span></div>
            </div>
            <div class="single__event__dates -flex">
                <div class="single__event__date">
                    <div><?=@$section['protection_date'];?></div>
                    <p>Защита проектов участниками</p>
                </div>
                <div class="single__event__date">
                    <div><?=@$section['discussion_date'];?></div>
                    <p>Обсуждение проектов членами жюри</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="grey-bg">
                    <h2>Ваши впечатления</h2>
                    <div class="form-textarea">
                        <form action="#" id="add-feedback">
                            <textarea name="text" placeholder="Оставьте ваш комментарий..."></textarea>
                            <button class="btn-yellow-small btn-submit" type="submit">Отправить</button>
                        </form>
                    </div>

                    <div class="col-articles__list simple-article white-text" id="section_feedbacks">
                        <?=$section_feedbacks;?>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="yellow-bg">
                    <h2>Говорят члены жюри секции</h2>
                    <div class="sayd-zhuri__list">
                        <?=$section_jury;?>
                    </div>
                </div>
            </div>
        </div>

        <?if(!empty($section_images)) {?>
        <div class="photogallery">
            <div class="title">Фотогалерея</div>
            <div class="photogallery__list">
                <?=$section_images;?>
            </div>
        </div>
        <?}?>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
<script src="/js/section-about.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>
