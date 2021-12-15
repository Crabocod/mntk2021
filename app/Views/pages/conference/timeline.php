<?php use App\Libraries\DateTime;

$this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Лента новостей']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="timeline">
    <div class="programs-page events-about">
        <div class="container">
            <div class="programs-block">
                <div class="programs-block_theme">Лента новостей</div>
                <div class="news-rows">
                    <?foreach ($news as $item):?>
                    <div class="news-row">
                        <div class="news-row_text-block">
                            <div class="news-row_title">
                                <a href="/news/<?=$item['id']?>"><?=$item['title']?></a>
                                <p><?= DateTime::formatRu($item['date'], 'd MMMM')?></p>
                            </div>
                            <div class="news-row_text">
                                <?=$item['short_text']?> </div>
                        </div>
                        <picture class="news-row_img">
                            <img src="/<?=(!empty($item['file_min_link']) ? $item['file_min_link'] : ($item['file_link'] ?? ''));?>">
                        </picture>
                        <?=$item['youtube_iframe']?>
                    </div>
                    <?endforeach;?>

                </div>

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
<script src="/js/conference/events-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>