<?php $this->extend('layouts/conferences'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/all/head', ['title' => 'МНТК 2021']); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo view('templates/all/scripts'); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

<?if(!empty($sort_blocks)):?>
    <?foreach ($sort_blocks as $sort_block):?>
        <?if($sort_block['id'] == 1):?>
            <?=view('templates/conference/index/block_1', $sort_block);?>
        <?elseif($sort_block['id'] == 2):?>
            <?=view('templates/conference/index/block_2', $sort_block);?>
        <?elseif($sort_block['id'] == 3):?>
            <?=view('templates/conference/index/block_3', $sort_block);?>
        <?elseif($sort_block['id'] == 4):?>
            <?=view('templates/conference/index/block_4', $sort_block);?>
        <?elseif($sort_block['id'] == 5):?>
            <?=view('templates/conference/index/block_5', $sort_block);?>
        <?elseif($sort_block['id'] == 6):?>
            <?=view('templates/conference/index/block_6', $sort_block);?>
        <?endif;?>
    <?endforeach;?>
<?else:?>
    <?=view('templates/conference/index/block_1', ['hide' => 0]);?>
    <?=view('templates/conference/index/block_3', ['hide' => 0]);?>
    <?=view('templates/conference/index/block_2', ['hide' => 0]);?>
    <?=view('templates/conference/index/block_6', ['hide' => 0]);?>
    <?=view('templates/conference/index/block_4', ['hide' => 0]);?>
    <?=view('templates/conference/index/block_5', ['hide' => 0]);?>
<?endif;?>
<?php $this->endSection(); ?>

<?php $this->section('footer'); ?>
<?php echo $this->include('templates/all/footer'); ?>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script src="/js/jstz.min.js"></script>
<?php $this->endSection(); ?>