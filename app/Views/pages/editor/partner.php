<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Хочу стать...']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>

    <div class="content-sidebar">
        <h1>Я хочу стать...</h1>
        <section class="section-grey">
            <form action="" id="wtb-text">
            <div class="form-row form-row-editor">
                <label for="#">Текст-описание</label>
                <textarea class="height-100" name="wtb_text" id="wtb_text"><?=$conference['wtb_text'];?></textarea>
            </div>
            <div class="form-row">
                <label for="#">Email-адрес для отправки заявок</label>
                <input type="text" name="wtb_email" class="required"  value="<?=$conference['wtb_email'];?>">
            </div>
            <div class="form-row">
                <button type="submit" class="btn-save-green">Сохранить</button>
            </div>
            </form>
        </section>
        <section class="section-grey">
            <h2>Варианты кнопок «Я хочу стать» </h2>
            <section>
                <table class="table-flex">
                    <tr>
                        <th>
                            <div class="row-item">
                                Текст
                            </div>
                        </th>
                        <th width="90px">
                            <div class="row-item">
                                Иконка
                            </div>
                        </th>
                        <th width="240px"></th>
                    </tr>
                    <?=@$member_groups;?>
                    <tr id="add-row">
                        <td>
                            <div class="row-item">
                                <textarea class="text"></textarea>
                            </div>
                        </td>
                        <td>
                            <div class="row-item"  id="add-icon">
                                <form class="icon">
                                    <div class="thumbnail_div" style="max-width: 35px;">
                                        <input name="img_link" type="file" class="thumbnail" accept="image/*">
                                        <span>Прикрепить иконку</span>
                                        <img class="icon" src="" width="30px"/>
                                        <img class="icon__delete" src="/img/delete-krest.svg" style="display: none">
                                    </div>
                                </form>
                            </div>
                        </td>
                        <td>
                            <div class="row-item">
                                <div class="btns-control">
                                    <a class="btn-save btn-save-dark ajax-add" href="#">Добавить</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </section>
        </section>
    </div>

<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/ckeditorHtmlEmbed/build/ckeditor.js"></script>
    <script src="/js/editor/partner-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>