<div class="row-form">
    <div class="row-form_item">
        <img src="/<?= (!empty($file_min_link))?$file_min_link:$file_link?>" alt="">
    </div>

    <div class="row-form_item"><?=@$title?></div>
    <div class="row-form_item ck-content"><?=@$short_text?></div>
    <div class="row-form_item row-buttons">
        <a class="row-buttons_edit" href="/admin/news/<?=$id?>"></a>
        <div class="btn-cancel js-delete" data-id="<?=$id?>"></div>
    </div>
</div>