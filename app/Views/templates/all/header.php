<?php $userSession = \App\Entities\Users\UserSession::getUser(); ?>

<header>
    <div class="header">
        <div class="container">
            <div class="header-block">
                <div class="header-first">
                    <a href="/">
                        <picture>
                            <source srcset="/img/logo-footer.webp" type="image/webp">
                            <img src="/img/logo-footer.png" />
                        </picture>
                    </a>
                    <div class="footer-text">XVI Межрегиональная научно-техническая конференция молодых специалистов ПАО
                        «НК «Роснефть»</div>
                </div>
                <div class="toggle-menu"><span></span></div>
                <div class="header-second">
                    <div class="navigation-mobile">
                    <div class="nav-container">
                    <a href="/">Главная</a>
                </div>
                <div class="nav-container">
                    <a class="nav-toggle">Деловая программа</a>
                    <div class="activity-toggle-block_list">
                        <div class="grid">
                            <?foreach (\App\Controllers\Pages\Conference\BaseController::$programs as $program):?>
                            <a href="/programs/<?=$program['id'] ?? '';?>"><?=$program['title'] ?? '';?><div class="arrow"></div></a>
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
                <div class="nav-container">
                    <a class="nav-toggle">Работа жюри</a>
                    <div class="activity-toggle-block_list">
                        <div class="grid">
                            <?foreach (\App\Controllers\Pages\Conference\BaseController::$sections as $section):?>
                                <a href="/sections/<?=$section['id'] ?? '';?>"><?=$section['title'] ?? '';?> <?=$section['number'] ?? '';?><div class="arrow"></div></a>
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
                <div class="nav-container">
                    <a class="nav-toggle">Развивающие мероприятия</a>
                    <div class="activity-toggle-block_list">
                        <div class="grid">
                            <a class="toggle-block_list-title" href="/acquaintance">Знакомство</a>
                            <a class="toggle-block_list-title">Мастер-классы</a>

                            <?foreach (\App\Controllers\Pages\Conference\BaseController::getEvents(1) as $event):?>
                                <a href="/events/<?=$event['id'] ?? '';?>"><?=$event['title'] ?? '';?><div class="arrow"></div></a>
                            <?endforeach;?>
                            </a>
                            <a class="toggle-block_list-title">Время эксперотов</a>
                            <?foreach (\App\Controllers\Pages\Conference\BaseController::getEvents(2) as $event):?>
                                <a href="/events/<?=$event['id'] ?? '';?>"><?=$event['title'] ?? '';?><div class="arrow"></div></a>
                            <?endforeach;?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="nav-container">
                    <a class="nav-toggle">Oil English Club</a>
                    <div class="activity-toggle-block_list">
                        <div class="grid">
                            <?foreach (\App\Controllers\Pages\Conference\BaseController::getEvents(4) as $event):?>
                                <a href="/events/<?=$event['id'] ?? '';?>"><?=$event['title'] ?? '';?><div class="arrow"></div></a>
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
                <div class="nav-container">
                    <a class="nav-toggle">Lounge Time</a>
                    <div class="activity-toggle-block_list">
                        <div class="grid">
                            <?foreach (\App\Controllers\Pages\Conference\BaseController::getEvents(3) as $event):?>
                                <a href="/events/<?=$event['id'] ?? '';?>"><?=$event['title'] ?? '';?><div class="arrow"></div></a>
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
                <div class="nav-container">
                    <a href="/chronograph">Хронограф</a>
                </div>
                <div class="nav-container">
                    <a href="/news">Лента новостей</a>
                </div>
                <div class="nav-container">
                    <a href="/archives">Архив мероприятий</a>
                </div>
                    </div>
                    <div class="header-auth">Вы авторизованы как</div>
                    <div class="header-name"><?=$userSession->full_name ?? '';?></div>
                    <a class="header-btn" href="/logout">Выйти</a>
                </div>
            </div>
        </div>
        <div class="header-nav">
            <div class="container">
                <div class="nav-container">
                    <a href="/">Главная</a>
                </div>
                <div class="nav-container">
                    <a class="nav-toggle">Деловая программа</a>
                    <div class="activity-toggle-block_list">
                        <div class="grid">
                            <?foreach (\App\Controllers\Pages\Conference\BaseController::$programs as $program):?>
                                <a href="/programs/<?=$program['id'] ?? '';?>"><?=$program['title'] ?? '';?><div class="arrow"></div></a>
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
                <div class="nav-container">
                    <a class="nav-toggle">Работа жюри</a>
                    <div class="activity-toggle-block_list">
                        <div class="grid">
                            <?foreach (\App\Controllers\Pages\Conference\BaseController::$sections as $section):?>
                                <a href="/sections/<?=$section['id'] ?? '';?>"><?=$section['title'] ?? '';?> <?=$section['number'] ?? '';?><div class="arrow"></div></a>
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
                <div class="nav-container">
                    <a class="nav-toggle">Развивающие мероприятия</a>
                    <div class="activity-toggle-block_list">
                        <div class="grid">
                            <a class="toggle-block_list-title" href="/acquaintance">Знакомство</a>
                            <a class="toggle-block_list-title">Мастер-классы</a>
                            <?foreach (\App\Controllers\Pages\Conference\BaseController::getEvents(1) as $event):?>
                                <a href="/events/<?=$event['id'] ?? '';?>"><?=$event['title'] ?? '';?><div class="arrow"></div></a>
                            <?endforeach;?>
                            </a>
                            <a class="toggle-block_list-title">Время эксперотов</a>
                            <?foreach (\App\Controllers\Pages\Conference\BaseController::getEvents(2) as $event):?>
                                <a href="/events/<?=$event['id'] ?? '';?>"><?=$event['title'] ?? '';?><div class="arrow"></div></a>
                            <?endforeach;?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="nav-container">
                    <a class="nav-toggle">Oil English Club</a>
                    <div class="activity-toggle-block_list">
                        <div class="grid">
                            <?foreach (\App\Controllers\Pages\Conference\BaseController::getEvents(4) as $event):?>
                                <a href="/events/<?=$event['id'] ?? '';?>"><?=$event['title'] ?? '';?><div class="arrow"></div></a>
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
                <div class="nav-container">
                    <a class="nav-toggle">Lounge Time</a>
                    <div class="activity-toggle-block_list">
                        <div class="grid">
                            <?foreach (\App\Controllers\Pages\Conference\BaseController::getEvents(3) as $event):?>
                                <a href="/events/<?=$event['id'] ?? '';?>"><?=$event['title'] ?? '';?><div class="arrow"></div></a>
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
                <div class="nav-container">
                    <a href="/chronograph">Хронограф</a>
                </div>
                <div class="nav-container">
                    <a href="/news">Лента новостей</a>
                </div>
                <div class="nav-container">
                    <a href="/archives">Архив мероприятий</a>
                </div>
            </div>
        </div>
    </div>
</header>