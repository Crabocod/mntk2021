<!doctype html>
<html lang="en">
<head>
    <?php echo $this->renderSection('scripts'); ?>
    <?php echo $this->renderSection('head'); ?>
</head>
<body>
<div class="wrapper">
    <header class="header">
        <div class="container -flex">
            <div class="header__name"><?=$conference['title'];?></div>
            <a class="header__btn" href="/editor/logout">Выйти</a>
        </div>
    </header>

    <div class="content">
        <div class="container -flex -justify-btw">
            <div class="nav-sidebar">
                <a href="/editor/<?=@$url_segments[1];?>/" class="<?=(empty($url_segments[2])?'active':'');?>">Главная страница</a>
                <a href="/editor/<?=@$url_segments[1];?>/users" class="<?=((isset($url_segments[2]) && $url_segments[2] == 'users')?'active':'');?>">Пользователи</a>
                <a href="/editor/<?=@$url_segments[1];?>/og-info" class="<?=((isset($url_segments[2]) && $url_segments[2] == 'og-info')?'active':'');?>">Информация об ОГ</a>
                <a href="/editor/<?=@$url_segments[1];?>/events" class="<?=((isset($url_segments[2]) && $url_segments[2] == 'events')?'active':'');?>">Ближайшие мероприятия</a>
                <a href="/editor/<?=@$url_segments[1];?>/archives" class="<?=((isset($url_segments[2]) && $url_segments[2] == 'archives')?'active':'');?>">Архив мероприятий</a>
                <a href="/editor/<?=@$url_segments[1];?>/news" class="<?=((isset($url_segments[2]) && $url_segments[2] == 'news')?'active':'');?>">Живая лента</a>
                <a href="/editor/<?=@$url_segments[1];?>/sections" class="<?=((isset($url_segments[2]) && $url_segments[2] == 'sections')?'active':'');?>">Работа секций</a>
                <a href="/editor/<?=@$url_segments[1];?>/feedback" class="<?=((isset($url_segments[2]) && $url_segments[2] == 'feedback')?'active':'');?>">Обратная связь</a>
                <a href="/editor/<?=@$url_segments[1];?>/partner" class="<?=((isset($url_segments[2]) && $url_segments[2] == 'partner')?'active':'');?>">Хочу стать участником...</a>
                <a href="/editor/<?=@$url_segments[1];?>/prof-quiz" class="<?=((isset($url_segments[2]) && $url_segments[2] == 'prof-quiz')?'active':'');?>">Профес викторина</a>
                <a href="/editor/<?=@$url_segments[1];?>/region-quiz" class="<?=((isset($url_segments[2]) && $url_segments[2] == 'region-quiz')?'active':'');?>">Викторина «Узнай регион»</a>
                <a href="/editor/<?=@$url_segments[1];?>/team-quest" class="<?=((isset($url_segments[2]) && $url_segments[2] == 'team-quest')?'active':'');?>">Результаты командного квеста</a>
                <a href="/editor/<?=@$url_segments[1];?>/radio" class="<?=((isset($url_segments[2]) && $url_segments[2] == 'radio')?'active':'');?>">Прямой эфир</a>
                <a href="/editor/<?=@$url_segments[1];?>/groups" class="<?=((isset($url_segments[2]) && $url_segments[2] == 'groups')?'active':'');?>">Группы участников</a>
                <a href="/editor/<?=@$url_segments[1];?>/management" class="<?=((isset($url_segments[2]) && $url_segments[2] == 'management')?'active':'');?>">Углеродный менеджмент</a>
            </div>

            <?php echo $this->renderSection('main'); ?>
        </div>
    </div>
</div>
<footer class="footer"></footer>
<script src="/js/bot-libs.js"></script>
</body>
<?php echo $this->renderSection('modals'); ?>
</html>