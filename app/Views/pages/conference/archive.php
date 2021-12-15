<?php
$dateFormatter = new \App\Libraries\DateFormatter();
?>

<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Архив Мероприятий']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="timeline">
    <div class="programs-page events-about">
        <div class="container">
            <div class="programs-block">
                <div class="programs-block_theme">Архив Мероприятий</div>
                <div class="news-rows public-archive-rows">
                    <?foreach ($archives ?? [] as $archive):
                        $preview_link = '';
                        if(!empty($archive['preview_min_file_link']))
                            $preview_link = $archive['preview_min_file_link'];
                        elseif(!empty($archive['preview_file_link']))
                            $preview_link = $archive['preview_file_link'];
                        $archive['date_from'] = \App\Libraries\DateTime::byUserTimeZone(\App\Entities\Users\UserSession::getUser(), $archive['date_from']);
                    ?>
                    <div class="news-row">
                        <div class="news-row_text-block">
                            <div class="news-row_title">
                                <a href="/archives/<?=$archive['id'] ?? '';?>"><?=$archive['title'] ?? '';?></a>
                                <p><?=(!empty($archive['date_from'])) ? $dateFormatter->withRelativeDate(true, true)->format_3($archive['date_from']) : '';?></p>
                            </div>
                            <div class="news-row_text ck-content"><?=$archive['short_text'] ?? '';?></div>
                        </div>
                        <?if(!empty($preview_link)):?>
                            <picture class="news-row_img">
                                <img src="/<?=$preview_link ?? '';?>">
                            </picture>
                        <?endif;?>
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