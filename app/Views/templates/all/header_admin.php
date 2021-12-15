<header class="header -flex -justify-between">
    <div class="logo"><a href="#"><img src="/img/logo.svg" alt=""/></a></div>
    <div class="header__login -flex -center"><span class="header__name"><?php echo session()->user->surname; ?> <?php echo session()->user->name; ?></span><a class="btn" href="/logout">Выйти</a></div>
</header>