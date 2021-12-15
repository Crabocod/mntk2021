<?php
$logo_file_link = '';
if(!empty($conference['logo_min_file']['link']))
    $logo_file_link = $conference['logo_min_file']['link'];
elseif(!empty($conference['logo_file']['link']))
    $logo_file_link = $conference['logo_file']['link'];
?>

<div class="main-page" style="<?=(!empty($hide)) ? 'display:none' : '';?>">
    <div class="container">
        <div class="mobile-main-nav">
            <a class="active" href="/">
                <div class="nav-svg home"></div>Главная
            </a>
            <a class="header-btn" href="/logout">Выйти</a>
        </div>
        <div class="main-nav">
            <div class="full-nav">
                <a class="active" href="/">
                    <div class="nav-svg home"></div>Главная
                </a>
                <a href="#event-page">
                    <div class="nav-svg activity"></div>Мероприятия
                </a>
                <a href="#news">
                    <div class="nav-svg news"></div>Лента новостей
                </a>
                <a href="#arhive">
                    <div class="nav-svg arhive"></div>Архив мероприятий
                </a>
            </div>
            <a class="header-btn" href="/logout">Выйти</a>
        </div>
        <div class="main-block">
            <div class="logo"
                 style="<?=(!empty($logo_file_link)) ? 'background: url('.$logo_file_link.') no-repeat' : '';?>">
            </div>
            <div class="main-title"><?=$conference['title'] ?? '';?>
                <p><?=$conference['sub_title'] ?? '';?>
                </p>
                <p class="main-date"><img src="/img/main-date.svg" alt=""> <?=$conference['date'] ?? '';?>
                </p>
            </div>
        </div>
        <div class="main-info">
            <div class="main-info_block">
                <?=$conference['specialist_num'] ?? '';?>
                <p>МОЛОДЫХ СПЕЦИАЛИСТОВ</p>
            </div>
            <div class="main-info_block">
                <?=$conference['og_num'] ?? '';?>
                <p>ОБЩЕСТВ ГРУППЫ</p>
            </div>
            <div class="main-info_block">
                <?=$conference['experts_num'] ?? '';?>
                <p>ЭКСПЕРТОВ ЦАУК</p>
            </div>
            <div class="main-info_block">
                <?=$conference['sections_num'] ?? '';?>
                <p>СЕКЦИЙ</p>
            </div>
            <div class="main-info_block">
                <?=$conference['projects_num'] ?? '';?>
                <p>ПРОЕКТОВ УЧАСТНИКОВ</p>
            </div>
        </div>
    </div>
</div>