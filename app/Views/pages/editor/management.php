<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Углеродный менеджмент']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="content-sidebar">
        <h1>Углеродный менеджмент</h1>

        <section class="section-grey">
            <form action="" id="management" method="post">
                <div class="form-row">
                    <label for="#">Заголовок</label>
                    <input value="<?=@$conference['management_title'];?>" type="text" name="management_title" autocomplete="off" class="required">
                </div>
                <div class="form-row form-row-editor">
                    <label for="#">Текст</label>
                    <textarea id="top_text" name="management_top_text"><?=esc(@$conference['management_top_text']);?></textarea>
                </div>
                <div class="form-row">
                    <label for="#">Презентация</label>
                    <div class="yellow-attach">
                        <input type="file" name="file" id="file-head" class="inputfile inputfile-1">
                        <label for="file-head">
                            <span><?=(!empty($conference['management_file_url'])) ? $conference['management_file_name'] : 'Прикрепить...';?></span>
                        </label>
                        <a class="btn-cancel file-delete" href="#" style="<?=(empty($conference['management_file_url']))?'display: none;':'';?>">Удалить</a>
                        <input type="hidden" name="deleted_file" value="0">
                    </div>
                </div>
                <div class="form-row form-row-editor">
                    <label for="#">Текст</label>
                    <textarea id="text" name="management_text"><?=esc(@$conference['management_text']);?></textarea>
                </div>
                <div class="form-row">
                    <div class="btns-control">
                        <button type="submit" class="btn-save btn-save-green">Сохранить</button>
                    </div>
                </div>
            </form>
        </section>

        <?if(!empty($feedbacks)):?>
            <section class="section-grey archive-feedbacks">
                <h2>Отзывы участников</h2>
                <table class="table-flex" id="feedbacks">
                    <tr>
                        <th >
                            <div class="row-item">
                                Имя
                            </div>
                        </th>
                        <th>
                            <div class="row-item">
                                Дата
                            </div>
                        </th>
                        <th width="380px">
                            <div class="row-item">
                                Текст
                            </div>
                        </th>
                        <th>
                            <div class="row-item">
                            </div>
                        </th>
                    </tr>
                    <?=@$feedbacks;?>
                </table>
            </section>
        <?endif;?>
    </div>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/ckeditorHtmlEmbed/build/ckeditor.js"></script>
    <script src="/js/editor/management-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>