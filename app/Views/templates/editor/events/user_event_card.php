<tr class="user_cards">
    <input type="hidden" id="user_id" value="<?=$id;?>">
    <td>
        <?=$user_name . ' ' . $user_surname;?> (<?=$user_email;?>)
    </td>
    <td style="width: 150px;">
        <?
        if ($status == 0)
            echo '<a class="btn-save ajax-accept" href="#">Разрешить</a>';
        elseif ($status == 1)
            echo '<span class="green-text">Принят для участия</span>';
        elseif ($status == 2)
            echo '<span class="grey-text ajax-decline">Отклонен</span>';
        ?>
    </td>
    <td>
        <?
        if ($status == 0)
            echo '<a class="btn-delete ajax-decline" href="#">Отклонить</a>';
        elseif ($status == 1)
            echo '<a class="btn-delete ajax-decline" href="#">Отклонить</a>';
        elseif ($status == 2)
            echo '<a class="btn-save ajax-accept" href="#">Разрешить</a>';
        ?>
    </td>
</tr>
