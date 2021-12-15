<div class="admin-block" data-block_id="1">
    <div class="injection">
        <a href="#" class="js-toggle-visible"><img src="<?=(!empty($hide)) ? '/img/hide.svg' : '/img/visible.svg';?>"
                alt=""></a>
        <a href="#" class="handle"><img src="/img/move.svg" alt=""></a>
    </div>
    <h4>Главный блок</h4>
    <form  id="main-block" enctype="multipart/form-data">
    <div class="admin-block_content ">
            <div class="admin-block_content-block">
                <h5>Лого</h5>
                <label class="btn" href="" for="logo"
                    title="<?=(!empty($logo_file_title)) ? $logo_file_title : 'Прикрепить';?>">
                    <input type="file" name="logo" id="logo" multiple="">
                    <img src="/img/screpka.svg"> <?=(!empty($logo_file_title)) ? $logo_file_title : 'Прикрепить';?>
                </label>
            </div>

            <div class="admin-block_content-block">
                <h5>Заголовок</h5>
                <input type="text" placeholder="Текст заголовка" name="title" value="<?=$title ?? '';?>">
            </div>

            <div class="admin-block_content-block">
                <h5>Дата</h5>
                <input type="text" placeholder="Дата" name="date" value="<?=$date ?? '';?>">
            </div>

            <div class="admin-block_content-block">
                <h5>Подзаголовок</h5>
                <input type="text" placeholder="Текст подзаголовока" name="sub_title" value="<?=$sub_title ?? '';?>">
            </div>
    </div>
    <div class="admin-block_content not-b">

        <div class="admin-block_content-block">
            <h5>Молодых специалистов</h5>
            <div class="admin-counter">
                <input name="specialist_num" type="number" value="<?=$specialist_num ?? '';?>">
            </div>
        </div>

        <div class="admin-block_content-block">
            <h5>Обществ групп</h5>
            <div class="admin-counter">
                <input name="og_num" type="number" value="<?=$og_num ?? '';?>">
            </div>
        </div>

        <div class="admin-block_content-block">
            <h5>Экспертов цаук</h5>
            <div class="admin-counter">
                <input name="experts_num" type="number" value="<?=$experts_num ?? '';?>">
            </div>
        </div>

        <div class="admin-block_content-block">
            <h5>Секций</h5>
            <div class="admin-counter">
                <input name="sections_num" type="number" value="<?=$sections_num ?? '';?>">
            </div>
        </div>

        <div class="admin-block_content-block">
            <h5>Проекта участников</h5>
            <div class="admin-counter">
                <input name="projects_num" type="number" value="<?=$projects_num ?? '';?>">
            </div>
        </div>
    </div>
    </form>
   
</div>