<div class="remodal center-text remodal-alert remodal-error" data-remodal-id="error"
     data-remodal-options="hashTracking: false, closeOnOutsideClick: true">
    <button class="remodal-close" data-remodal-action="close"></button>
    <form action="#" id="password_recovery">
        <input type="hidden" name="conference_id" value="4">
        <p class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
            magna aliqua.</p>
        <div class="form-row">
            <button class="btn-submit btn btn-yellow" data-remodal-action="close">Закрыть</button>
        </div>
    </form>
</div>
<div class="remodal center-text remodal-alert remodal-delete" data-remodal-id="confirm"
     data-remodal-options="hashTracking: false, closeOnOutsideClick: true">
    <button class="remodal-close" data-remodal-action="close"></button>
    <form action="#">
        <p class="message">Подтвердить действие?</p>
        <div class="btns-control -flex -center">
            <a class="btn btn-black" href="#" data-remodal-action="close">Закрыть</a>
            <a class="btn btn-yellow" href="#" data-remodal-action="confirm">Подтвердить</a>
        </div>
    </form>
</div>
<div class="remodal center-text remodal-alert remodal-success" data-remodal-id="success"
     data-remodal-options="hashTracking: false, closeOnOutsideClick: true">
    <button class="remodal-close" data-remodal-action="close"></button>
    <form action="#">
        <p class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
            magna aliqua.</p>
        <div class="form-row">
            <button class="btn-submit btn" data-remodal-action="close">Закрыть</button>
        </div>
    </form>
</div>
<div class="remodal" data-remodal-id="result-recovery-pass"
     data-remodal-options="hashTracking: false, closeOnOutsideClick: true">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="confim-modal">
        <h3>Новый пароль отправлен<br>
            на вашу почту</h3>
        <p>Не забудьте проверить папку СПАМ</p>
    </div>
</div>
<div class="remodal" data-remodal-id="recovery-pass"
     data-remodal-options="hashTracking: false, closeOnOutsideClick: true">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="title">Восстановление пароля</div>
    <form action="#" id="password_recovery">
        <input type="hidden" name="conference_id" value="4">
        <div class="form-row">
            <label for="#">Введите Email</label>
            <input type="email" name="email">
        </div>
        <div class="form-row">
            <button class="btn-submit">Отправить</button>
        </div>
    </form>
</div>
<div class="remodal remodal-comment" data-remodal-id="comment"
     data-remodal-options="hashTracking: false, closeOnOutsideClick: true">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="title">ПОДЕЛИТЕСЬ ВПЕЧАТЛЕНИЯМИ</div>
    <form action="#" id="comment">
        <div class="form-row">
<!--            <label for="#">Введите</label>-->
            <textarea name="text" id="" rows="10"></textarea>
        </div>
        <div class="grade-blocks">
                    <div class="grade-block_title">Ваша оценка:</div>
                    <div class="grade-row">
                        <a href="#" class="like grade-block active" data-grade="1">
                            <div class="like-svg"></div>
                        </a>
                        <a href="#" class="dislike grade-block  dis" data-grade="0">
                            <div class="dislike-svg"></div>
                        </a>
                    </div>
                </div>
        <div class="form-row">
            <button class="btn-submit btn btn-yellow btn-grade">Отправить</button>
        </div>
    </form>
</div>