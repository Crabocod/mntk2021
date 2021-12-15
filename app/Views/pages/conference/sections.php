<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Секция '.($number??1).' «'.($title ?? '').'»']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="section-page">
    <div class="programs-page">
        <div class="container">
            <div class="programs-block">
                <div class="theme-block">
                    <div class="programs-block_title">Работа жюри</div>
                    <div class="programs-block_theme">Секция №<?=$number ?? 1;?> «<?=$title ?? '';?>»</div>
                    <div class="programs-block_sub-title"><?=$protection_date ?? '';?> <span><?=$time ?? '';?></span></div>
                    <div class="programs-info_blocks">
                        <div class="programs-text_block">
                            <div class="programs-text_block-title">
                                Состав жюри
                            </div>
                            <div class="programs-text_block-text">
                                <ul>
                                    <?if(!empty($jury)):?>
                                        <?foreach ($jury as $item):?>
                                            <li><?=$item['speaker'];?></li>
                                        <?endforeach;?>
                                    <?endif;?>
                                </ul>
                            </div>
                        </div>
                        <div class="programs-text_block">
                            <div class="programs-text_block-title">
                                Список участников
                            </div>
                            <div class="programs-text_block-text">
                            <ul>
                                <?if(!empty($members)):?>
                                    <?foreach ($members as $member):?>
                                        <li><?=$member['full_name'];?></li>
                                    <?endforeach;?>
                                <?endif;?>
                            </ul>
                            </div>
                        </div>
                    </div>
                
                    <a class="programs-btn section-feedbacks-btn" href="#" data-remodal-target="comment"><img src="/img/speak-btn.svg">Поделиться впечатлениями от защиты</a>
                </div>
                <?if(!empty($feedbacks)):?>
                    <div class="new-reviews_blocks" id="feedback_rows">
                        <?foreach ($feedbacks as $feedback):?>
                            <?=view('templates/conference/all/feedback_row', ['feedback' => $feedback]);?>
                        <?endforeach;?>
                    </div>
                <?endif;?>
                <?if(!empty($gallery)):?>
                <div class="photo-report_block">
                    <h2>фотоотчет</h2>
                    <div class="photo-slides">
                        <?foreach ($gallery as $image):?>
                        <div class="photo-slide">
                            <picture>
                                <img src="<?=$image['img_min_file_link'];?>">
                            </picture>
                        </div>
                        <?endforeach;?>
                    </div>
                </div>
                <?endif;?>
            </div>
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
<script src="/js/conference/sections-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>