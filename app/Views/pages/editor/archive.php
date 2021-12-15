<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Архив мероприятий']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="content-sidebar">
        <a class="to-back" href="/editor/<?=$conference['id'];?>/archives"><-- Вернуться к архиву мероприятий</a>
        <h1>Редактирование </h1>

        <section class="section-grey">
            <form action="" id="archive" method="post">
                <input type="hidden" name="id" value="<?=@$archive['id'];?>">
                <div class="form-row">
                    <label for="#">Заголовок</label>
                    <input value="<?=@$archive['title'];?>" type="text" name="title" autocomplete="off" class="required">
                </div>
                <div class="form-row">
                    <label for="#">Дата </label>
                    <input value="<?=@$archive['date'];?>" type="text" name="date" autocomplete="off" class="required litepicker-date" placeholder="дд.мм.гггг">
                </div>
                <div class="form-row form-row-editor">
                    <label for="#">Полный текст архива</label>
                    <textarea id="full_text" name="full_text"><?=esc(@$archive['full_text']);?></textarea>
                </div>
                <div class="form-row">
                    <div class="btns-control">
                        <button type="submit" class="btn-save btn-save-green">Сохранить</button>
                        <a class="btn-cancel" href="#">Удалить</a>
                    </div>
                </div>
            </form>
        </section>

        <section class="section-grey">
            <h2>Материалы мероприятия</h2>
            <?=$archive_files;?>
            <div class="form-row" id="add-file-row">
                <div class="yellow-attach">
                    <form action="">
                        <input type="file" name="link" id="file-2" class="inputfile inputfile-1">
                        <label for="file-2"> <span>Прикрепить...</span></label>
                    </form>
                </div>
            </div>
        </section>

        <?if(!empty($archive_feedbacks)):?>
        <section class="section-grey archive-feedbacks">
            <h2>Отзывы участников</h2>
            <table class="table-flex" id="archive_feedbacks">
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
                <?=@$archive_feedbacks;?>
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
    <script src="/js/editor/archive-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>