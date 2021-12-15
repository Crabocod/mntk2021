<div class="qustion-block">

    <div class="block-resize">
    <input type="hidden" name="id" value="<?=$id?>">
    <div class="qustion-num">Вопрос №<?=@$number?></div>
    <div class="qustion-block_title"><?=@$title?></div>
    <div class="qustion-block_text">
        <?=@$text?>
        <?
        foreach ($files as $file) {
            $file = $file->toRawArray();
            switch ($file['type_id']){
                case '1':
                    echo '<audio controls src="'.$file['file_link'].'">
                                    Your browser does not support the
                                    <code>audio</code> element.
                                </audio>';
                    break;
                case '2':
                    echo '<div class="qustion-files"><img src="/img/chrono-file.svg">'.$file['file_title'].'</div>';
                    break;
                case '3':
                    echo '<img src="'.$file['file_link'].'">';
                    break;
            }
        }
        ?>
            <?=@$youtube_iframe?>
        </div>
    </div>
    <div class="block-static">
        <div class="answer-title">Ответ:</div>
        <textarea name="answer" id="" placeholder="Напишите ответ здесь"><?=@$text_answer?></textarea>
        <a class="programs-btn send-answer-js" href="#">Отправить</a>

    </div>
</div>