<div class="victorina-quest">
    <div class="quest__title">Вопрос №<?=@$number;?></div>
    <?if(!empty($text)):?>
        <p><?=@$text;?></p>
    <?endif;?>
    <?if(!empty($youtube_iframe)):?>
        <?=@$youtube_iframe;?>
    <?endif;?>
    <?if(!empty($img)):?>
        <img src="/<?=$img;?>">
    <?endif;?>
    <?if(!empty($audio)):?>
        <audio controls>
            <source src="/<?=$audio;?>">
            Тег audio не поддерживается вашим браузером.
            <a href="/<?=$audio;?>">Скачайте аудио</a>.
        </audio>
    <?endif;?>
    <?if(!empty($file)):?>
        <div class="proff-quiz-file_list">
            <p>
                <a href="/<?=$file;?>" target="_blank"><?=@$file_title;?></a>
            </p>
        </div>
    <?endif;?>
    <form action="#" class="save_answer" enctype="multipart/form-data">
        <input type="hidden" value="<?=@$id;?>" name="professional_quiz_question_id">
        <textarea name="text" placeholder="Ваш ответ"><?=@$answer;?></textarea>
        <div class="form-row">
            <div class="yellow-attach">
                <input type="file" name="file" id="file-head-<?=@$id;?>" class="inputfile inputfile-1">
                <label for="file-head-<?=@$id;?>">
                    <span><?=(!empty($answer_file)) ? @$answer_file_name : 'Прикрепить файл';?></span>
                </label>
                <a class="btn-cancel answer-file-delete" href="#" style="<?=(empty($answer_file))?'display: none;':'';?>">Удалить</a>
                <input type="hidden" name="deleted_file" value="0">
            </div>
        </div>
        <button class="btn-yellow-medium btn-submit" type="submit">Сохранить ответ</button>
    </form>
    <div class="victorina-quest__nom"><?=@$number;?></div>
</div>