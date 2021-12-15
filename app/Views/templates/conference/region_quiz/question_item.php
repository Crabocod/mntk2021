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
    <form action="#" class="save_answer">
        <input type="hidden" value="<?=@$id;?>" name="region_quiz_question_id">
        <textarea name="text" placeholder="Ваш ответ"><?=@$answer;?></textarea>
        <button class="btn-yellow-medium btn-submit" type="submit">Сохранить ответ</button>
    </form>
    <div class="victorina-quest__nom"><?=@$number;?></div>
</div>