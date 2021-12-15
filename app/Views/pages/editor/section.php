<?php $this->extend('layouts/editor'); ?>

<?php $this->section('head'); ?>
<?php echo view('templates/admin/all/head', ['title' => 'Новости']); ?>
<?php $this->endSection(); ?>

<?php $this->section('main'); ?>
    <div class="content-sidebar">
        <a class="to-back" href="/editor/<?=$conference['id'];?>/sections"><-- Вернуться к работам секций</a>
        <h1>Редактирование </h1>

        <section class="section-grey">
            <form action="" id="save_section">
                <input type="hidden" name="id" value="<?=@$section['id'];?>">
                <div class="form-row">
                    <label for="#">Номер секции</label>
                    <input type="text" name="title_1" class="required" value="<?=@$section['title_1'];?>">
                </div>
                <div class="form-row">
                    <label for="#">Название  </label>
                    <input type="text" name="title_2" class="required" value="<?=@$section['title_2'];?>">
                </div>
                <div class="form-row">
                    <label for="#">Дата защиты проектов участниками</label>
                    <div class="data-time -flex -center">
                        <input value="<?=(isset($section['protection_date']))?date('Y-m-d', strtotime($section['protection_date'])):'';?>" type="text" name="protection_date" autocomplete="off" class="required litepicker-date date" placeholder="дд.мм.гггг">
                        в
                        <input class="required" type="time" name="protection_time" autocomplete="off" value="<?=(!empty($section['protection_date']))?date('H:i', strtotime(@$section['protection_date'])):'';?>">
                    </div>
                </div>
                <div class="form-row">
                    <label for="#">Дата обсуждения проектов членами жюри</label>
                    <div class="data-time -flex -center">
                        <input value="<?=(!empty($section['discussion_date']))?date('Y-m-d', strtotime($section['discussion_date'])):'';?>" type="text" name="discussion_date" autocomplete="off" class="required litepicker-date date" placeholder="дд.мм.гггг">
                        в
                        <input class="required" type="time" name="discussion_time" autocomplete="off" value="<?=(!empty($section['discussion_date']))?date('H:i', strtotime(@$section['discussion_date'])):'';?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="btns-control">
                        <button type="submit" class="btn-save btn-save-green">Сохранить</button>
                        <a class="btn-cancel" id="delete_section" href="#">Удалить</a>
                    </div>
                </div>
            </form>
        </section>

        <?if(!empty($section_feedbacks)):?>
        <section class="section-grey section-feedbacks">
            <h2>Впечатления участников</h2>
            <table class="table-flex">
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
                <?=@$section_feedbacks;?>
            </table>
        </section>
        <?endif;?>

        <section class="section-grey">
            <h2>Говорят члены жюри</h2>
            <section id="section_jury">
                <div class="grid grid-4 header-grid">
                    <div class="row-item">
                        Имя
                    </div>
                    <div class="row-item">
                        Iframe Youtube
                    </div>
                    <div class="row-item">
                        Текст
                    </div>
                    <div class="row-item"> </div>
                </div>
                <?=@$section_jury;?>
                <form class="grid grid-4 body-grid" id="add-section-jury">
                    <div class="row-item">
                        <input type="text" name="speaker" value="" class="required">
                    </div>
                    <div class="row-item">
                        <textarea class="height-100" name="youtube_iframe"></textarea>
                    </div>
                    <div class="row-item">
                        <textarea class="height-100" name="text"></textarea>
                    </div>
                    <div class="row-item">
                        <div class="btns-control">
                            <button type="submit" class="btn-save btn-save-dark">Добавить</button>
                        </div>
                    </div>
                </form>
            </section>
        </section>

        <section class="section-grey">
            <h2>Фотогалерея</h2>
            <div class="admin-photos sortable-images">
                <?=@$section_images;?>
                <form class="admin-photos__item disabled">
                    <div class="add-photo">
                        <label for="add-photo">
                            <input id="add-photo" type="file" name="img_orig" accept="image/*">
                            <span>Добавить</span>
                        </label>
                    </div>
                </form>
            </div>
        </section>
    </div>
<?php $this->endSection(); ?>

<?php $this->section('modals'); ?>
<?php echo $this->include('templates/all/modals'); ?>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<?php echo $this->include('templates/all/scripts'); ?>
    <script src="/js/editor/section-page.js?v=<?=\Config\SiteVersion::$main;?>"></script>
<?php $this->endSection(); ?>