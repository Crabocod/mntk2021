<tr>
    <td>
        <div class="row-item">
            <p><?=@$user_surname;?> <?=@$user_name;?></p>
        </div>
    </td>
    <td>
        <div class="row-item">
            <p><?=@$user_email;?></p>
        </div>
    </td>
    <td>
        <div class="row-item">
            <div class="toggle-list">
                <a  class="toggle-list__open unselectable">раскрыть...</a>
                <div class="hidden-toggle" style="display: none">
                    <?foreach (@$answers as $answer) :?>
                    <p>Вопрос:
                        <span><?=@$answer['text_question'];?></span>
                    </p>
                    <p>Ответ:
                        <span><?=@$answer['text_answer'];?></span>
                        <span><a target="_blank" href="/<?=@$answer['file'];?>"><?=@$answer['file_name'];?></a></span>
                    </p>
                    <?endforeach;?>
                </div>
            </div>
        </div>
    </td>
</tr>