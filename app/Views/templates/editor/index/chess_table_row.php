<form class="grid grid-6 body-grid shahmatka-grid-6 chess-row">
    <input type="hidden" name="id" value="<?=$id ?? '';?>">
    <div class="row-item row-item-date">
        <input name="date" type="text" value="<?=$date ?? '';?>" class="litepicker-date required" placeholder="дд.мм.гггг" autocomplete="off" />
    </div>
    <div class="row-item-date row-item">
        <input class="required" type="time" name="time" autocomplete="off"
               value="<?=date('H:i', strtotime($date ?? ''));?>">
    </div>
    <div class="row-item">
        <input name="type" class="required" type="text" value="<?=$type ?? '';?>">
    </div>
    <div class="row-item">
        <input name="title" class="required" type="text" value="<?=$title ??'';?>"/>
    </div>
    <div class="row-item">
        <input name="page_url" class="required" type="text" value="<?=$page_url ?? '';?>">
    </div>
    <div class="row-item add-icon-row">
        <div class="thumbnail_div">
            <input name="icon" type="file" class="thumbnail" accept="image/*">
            <input type="hidden" name="deleted_icon" value="0">
            <span style="display: none">Прикрепить иконку</span>
            <div class="icon"><img src="<?=(!empty($img_link)) ? $img_link : '/img/shahmatka.svg';?>" height="17px"></div>
            <label for="audio-upload" class="crhrono-label">
                <img class="icon__delete" src="<?=(!empty($img_link)) ? '/img/delete-krest.svg' : '/img/skrepka.svg';?>">
            </label>
        </div>
    </div>
    <div class="row-item">
        <div class="btns-control">
            <button type="submit" class="btn btn-save">Сохранить</button>
            <a href="#">
                <div class="btn-cancel"></div>
            </a>
        </div>
    </div>
</form>

<!--<form class="grid grid-6 body-grid shahmatka-grid-6 chess-row">-->
<!--    <input type="hidden" name="id" value="24">-->
<!--    <div class="row-item">-->
<!--        <input name="date" type="text" value="2021-04-30"-->
<!--               class="litepicker-date required" placeholder="дд.мм.гггг"-->
<!--               autocomplete="off">-->
<!---->
<!--    </div>-->
<!--    <div class="row-item-date row-item">-->
<!--        <input class="required" type="time" name="time" autocomplete="off"-->
<!--               value="10:50">-->
<!--    </div>-->
<!--    <div class="row-item">-->
<!--        <input name="type" class="required" type="text" value="Мастер-класс">-->
<!--    </div>-->
<!--    <div class="row-item">-->
<!--        <input name="title" class="required" type="text"-->
<!--               value="Заголовок мероприятия">-->
<!--    </div>-->
<!--    <div class="row-item">-->
<!--        <input name="page_url" class="required" type="text" value="Ccылка">-->
<!--    </div>-->
<!--    <div class="row-item add-icon-row">-->
<!--        <div class="thumbnail_div">-->
<!--            <input name="img_link" type="file" class="thumbnail" accept="image/*">-->
<!--            <input type="hidden" name="deleted_icon" value="0">-->
<!--            <span style="display: none">Прикрепить иконку</span>-->
<!--            <div class="icon"><img src="/img/shahmatka.svg" height="17px"></div>-->
<!--            <img class="icon__delete" src="/img/delete-krest.svg">-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="row-item">-->
<!--        <div class="btns-control">-->
<!--            <button type="submit" class="btn">Сохранить</button>-->
<!--            <a href="#">-->
<!--                <div class="btn-cancel"></div>-->
<!--            </a>-->
<!--        </div>-->
<!--    </div>-->
<!--</form>-->