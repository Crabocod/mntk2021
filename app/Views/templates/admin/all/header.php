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
                    <div class="header-auth">Вы авторизованы как</div>
                    <div class="header-name"><?=$userSession->full_name ?? '';?></div>
                    <a class="header-btn" href="/admin/logout">Выйти</a>
                </div>
            </div>
        </div>
    </div>
</header>

