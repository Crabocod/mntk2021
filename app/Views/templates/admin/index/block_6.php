<div class="admin-block" data-block_id="6">
    <div class="injection">
        <a href="#" class="js-toggle-visible"><img src="<?=(!empty($hide)) ? '/img/hide.svg' : '/img/visible.svg';?>"
                alt=""></a>
        <a href="#" class="handle"><img src="/img/move.svg" alt=""></a>
    </div>
    <h4>Шахматка</h4>
    <section>
        <div class="grid grid-6 header-grid header-shahmatka-grid-6">
            <div class="row-item">
                Дата
            </div>
            <div class="row-item">
                Время
            </div>
            <div class="row-item">
                Тип мероприятия
            </div>
            <div class="row-item">
                Название
            </div>
            <div class="row-item">
                Ссылка
            </div>
            <div class="row-item">
                Иконка
            </div>
        </div>
        <div class="border-table">
            <?=$chess ?? '';?>

            <form class="grid grid-6 body-grid shahmatka-grid-6 chess-row" id="add-chess">
                <div class="row-item">
                    <input name="date" type="text" class="litepicker-date required" autocomplete="off">
                </div>
                <div class="row-item-date row-item">
                    <input class="required" type="time" name="time">
                </div>
                <div class="row-item">
                    <input name="type" class="required" type="text" placeholder="Мастер-класс">
                </div>
                <div class="row-item">
                    <input name="title" class="required" type="text" placeholder="Заголовок мероприятия">
                </div>
                <div class="row-item">
                    <input name="page_url" class="required" type="text" placeholder="Ccылка">
                </div>
                <div class="row-item add-icon-row">
                    <div class="thumbnail_div">
                        <input name="icon" type="file" class="thumbnail" accept="image/*">
                        <input type="hidden" name="deleted_icon" value="0">
                        <span style="display: none">Прикрепить иконку</span>
                        <div class="icon"><img src="/img/shahmatka.svg" height="17px"></div>
                        <label for="audio-upload" class="crhrono-label"><img class="icon__delete" src="/img/skrepka.svg"></label>
                    </div>
                </div>
                <div class="row-item">
                    <div class="btns-control">
                        <button type="submit" class="btn add-btn">Добавить</button>
                        <a href="#" style="visibility: hidden">
                            <div class="btn-cancel"></div>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>