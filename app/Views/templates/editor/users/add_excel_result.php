<p class="message">Добавлено: <?= (isset($count_add)) ? $count_add : 0; ?></p>
<p class="message">Пользователей с ошибками: <?= (isset($count_error)) ? $count_error : 0; ?></p>
<?if(!empty($error_users)):?>
<table class="result_info">
    <tr>
        <th>Строка: </th>
        <th>Имя: </th>
        <th>Фамилия: </th>
        <th>Email: </th>
    </tr>
    <?foreach ($error_users as $user):?>
    <tr>
        <td><?=@$user->excel_row;?></td>
        <td><?=@$user->name;?></td>
        <td><?=@$user->surname;?></td>
        <td><?=@$user->email;?></td>
    </tr>
    <?endforeach;?>
</table>
<?endif;?>