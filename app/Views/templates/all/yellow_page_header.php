<header class="header">
    <div class="container -flex">
        <a href="/<?=$conferences->url_segment;?>" class="logo-container -flex">
            <div class="logo">
                <img src="/img/logo.png" alt="">
            </div>
            <div class="logo-text"><?=$conferences->title_head;?></div>
        </a>
        <div class="item">
            <button class="cmn-toggle-switch cmn-toggle-switch__htx">
                <span>toggle menu</span>
            </button>
        </div>
        <div class="mobile-menu">
            <div class="logo-container -flex">
                <div class="logo">
                    <img src="img/logo.png" alt="">
                </div>
                <div class="logo-text"><?=$conferences->title_head;?></div>
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="/<?=$conferences->url_segment;?>">Главная</a>
                    </li>
                    <li>
                        <a href="/<?=$conferences->url_segment;?>/og-info">Информация об ОГ</a>
                    </li>
                    <li>
                        <a href="/<?=$conferences->url_segment;?>/events">Ближайшие мероприятия</a>
                    </li>
                    <li>
                        <a href="/<?=$conferences->url_segment;?>/news">Живая лента</a>
                    </li>
                    <li>
                        <a href="/<?=$conferences->url_segment;?>/sections">Работа секций</a>
                    </li>
                    <li>
                        <a href="/<?=$conferences->url_segment;?>/archive">Архив мероприятий</a>
                    </li>
                </ul>
            </nav>
            <div class="header__personal">
                <span>Вы авторизованы как</span>
                <div class="user-name"><?=@$user_surname;?> <?=@$user_name;?></div>
                <a class="btn" href="/logout">Выйти</a>
            </div>
        </div>
    </div>
</header>
<div class="main-menu">
    <div class="container">
        <nav>
            <ul class="-flex">
                <li>
                    <a href="/<?=$conferences->url_segment;?>">Главная</a>
                </li>
                <li>
                    <a href="/<?=$conferences->url_segment;?>/og-info">Информация об ОГ</a>
                </li>
                <li>
                    <a href="/<?=$conferences->url_segment;?>/events">Ближайшие мероприятия</a>
                </li>
                <li>
                    <a href="/<?=$conferences->url_segment;?>/news">Живая лента</a>
                </li>
                <li>
                    <a href="/<?=$conferences->url_segment;?>/sections">Работа секций</a>
                </li>
                <li>
                    <a href="/<?=$conferences->url_segment;?>/archive">Архив мероприятий</a>
                </li>
            </ul>
        </nav>
    </div>
</div>