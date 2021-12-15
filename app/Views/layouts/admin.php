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
            <div class="header__name">Панель управления администратора</div>
            <a class="header__btn" href="/admin/logout">Выйти</a>
        </div>
    </header>

    <div class="main-menu">
        <div class="container">
            <nav>
                <ul class="-flex">
                    <li>
                        <a class="<?=(empty($url_segments[1])) ? 'active' : '';?>" href="/admin">Конференции</a>
                    </li>
                    <li>
                        <a class="<?=(isset($url_segments[1]) && $url_segments[1] == 'admin-users')?'active':'';?>" href="/admin/admin-users">Администраторы</a>
                    </li>
                    <li>
                        <a class="<?=(isset($url_segments[1]) && $url_segments[1] == 'editors')?'active':'';?>" href="/admin/editors">Редакторы</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <?php echo $this->renderSection('main'); ?>
</div>
<footer class="footer"></footer>
<script src="/js/bot-libs.js"></script>
</body>
<?php echo $this->renderSection('modals'); ?>
</html>