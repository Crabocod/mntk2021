<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Знакомство']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

<div class="accuainatce_page">
    <div class="container">
        <h2><?=$title ?? '';?></h2>
        <div class="programs-block">
            <form class="first-block" id="comment">
                <div class="mobile-titles">
                    <div class="programs-block_title ck-content">
                        <?=$text ?? '';?>
                    </div>
                    <h3>Поделитесь впечатлениями!</h3>
                </div>
                <textarea name="text" id="" placeholder="Напишите свой отзыв здесь"><?=(!empty($feedback['text'])) ? esc($feedback['text']) : '';?></textarea>

                <div class="grade-blocks">
                    <div class="grade-block_title">Ваша оценка:</div>
                    <div class="grade-row">
                        <a href="#" class="grade-block <?=(!empty($feedback) && $feedback['grade'] == 1) ? 'active' : '';?>" data-grade="1">
                            <div class="like-svg"></div>
                        </a>
                        <a href="#" class="grade-block <?=(!empty($feedback) && $feedback['grade'] == 0) ? 'active' : '';?> dis" data-grade="2">
                            <div class="dislike-svg"></div>
                        </a>
                    </div>
                </div>
                <a class="programs-btn btn-submit" href="#">ПОДЕЛИТЬСЯ ВПЕЧАТЛЕНИЯМИ</a>
            </form>
            <div class="second-block">
                <?=$youtube_iframe ?? '';?>
            </div>
        </div>
        <div class="programs-block">
            <?if(!empty($feedbacks)):?>
                <div class="new-reviews_blocks" id="feedback_rows">
                    <?foreach ($feedbacks as $feedback):?>
                        <?=view('templates/conference/all/feedback_row', ['feedback' => $feedback]);?>
                    <?endforeach;?>
                </div>
            <?endif;?>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('footer'); ?>
<?php echo $this->include('templates/all/footer'); ?>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
<script src="/js/jstz.min.js"></script>
<script src="/js/conference/acquaintance-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>