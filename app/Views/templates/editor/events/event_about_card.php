    <section class="section-grey">
      <form action="" id="save-event" enctype="multipart/form-data">
        <div class="form-row">
            <label for="#">Изображение превью</label>
            <div class="yellow-attach">
                <input type="file" name="event_preview" id="file-1" class="inputfile inputfile-1" accept="image/*">
                <label for="file-1"> <span><?=(!empty($preview_img_name)) ? $preview_img_name : 'Прикрепить...';?></span></label>
            </div>
        </div>
        <div class="form-row">
            <label for="#">Заголовок</label>
            <input type="text" name="title" required value="<?=$title;?>">
        </div>
        <div class="form-row">
            <label for="#">Дата </label>
            <div class="data-time -flex -center">
                <input name="date" type="text" value="<?=$date;?>" class="litepicker-date required date" placeholder="дд.мм.гггг" autocomplete="off">
                в
                <input name="time" class="required" type="time" autocomplete="off" value="<?=date('H:i', strtotime($date));?>">
            </div>
        </div>
        <div class="form-row">
            <label for="#">Спикер </label>
            <input name="speaker" type="text" value="<?=$speaker;?>" class="required" autocomplete="off">
        </div>
        <div class="form-row form-row-editor">
            <label for="#">Краткий текст новости</label>
            <textarea name="short_text" id="short_text"><?=esc($short_text);?></textarea>
        </div>
        <div class="form-row form-row-editor">
            <label for="#">Полный текст новости</label>
            <textarea name="full_text" id="full_text"><?=esc($full_text);?></textarea>
        </div>
        <div class="form-row form-row-editor">
            <label for="#">Включить кнопку записаться</label>
            <label class="switch">
                <input type="checkbox" name="show_button" <?=(!empty($show_button))?'checked':'';?>>
                <span class="slider"></span>
            </label>
        </div>
        <div class="form-row">
            <div class="btns-control">
                <button type="submit" class="btn-save-green">Сохранить</button>
                <a class="btn-cancel ajax-delete" href="#">Удалить</a>
                <input type="hidden" id="event_id" value="<?=$id;?>">
            </div>
        </div>
      </form>
    </section>

    <?if(!empty($userCards)):?>
    <section class="section-grey">
        <div class="-flex -center">
            <h2>Участники</h2>
            <a class="expot-exl" href="#" id="expot-exl">Экспортировать в &nbsp;Excel</a>
        </div>
        <table class="simple-table">
          <?=$userCards;?>
        </table>
    </section>
    <?endif;?>
