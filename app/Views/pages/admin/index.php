<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'Главная - Админ']); ?>
<?php $this->endSection(); ?>

<?php $this->section('header'); ?>
<?php echo $this->include('templates/admin/all/header'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
<div class="admin-page">
    <div class="container">
        <div class="admin-wrap">
            <?=view('templates/admin/all/menu');?>
            <div class="admin-content">
                <h2>Главная</h2>

               
                <div id="js-sort-blocks">
                    <?if(!empty($sort_blocks)):?>
                    <?foreach ($sort_blocks as $sort_block):?>
                    <?if($sort_block['id'] == 1):?>
                    <?=view('templates/admin/index/block_1', array_merge($conference ?? [], $sort_block));?>
                    <?elseif($sort_block['id'] == 2):?>
                    <?=view('templates/admin/index/block_2', $sort_block);?>
                    <?elseif($sort_block['id'] == 3):?>
                    <?=view('templates/admin/index/block_3', $sort_block);?>
                    <?elseif($sort_block['id'] == 4):?>
                    <?=view('templates/admin/index/block_4', $sort_block);?>
                    <?elseif($sort_block['id'] == 5):?>
                    <?=view('templates/admin/index/block_5', $sort_block);?>
                    <?elseif($sort_block['id'] == 6):?>
                    <?=view('templates/admin/index/block_6', $sort_block);?>
                    <?endif;?>
                    <?endforeach;?>
                    <?else:?>
                    <?=view('templates/admin/index/block_1');?>
                    <?=view('templates/admin/index/block_2');?>
                    <?=view('templates/admin/index/block_3');?>
                    <?=view('templates/admin/index/block_4');?>
                    <?=view('templates/admin/index/block_5');?>
                    <?=view('templates/admin/index/block_6');?>
                    <?endif;?>
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
<script src="/js/admin/index-page.js?v=<?= \Config\SiteVersion::$main; ?>"></script>
<?php $this->endSection(); ?>