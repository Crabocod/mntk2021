<?php
use CodeIgniter\Config\Services;

$userSession = \App\Entities\Users\UserSession::getUser();
$router = Services::router()->getMatchedRoute();
$path = (!empty($router[0])) ? $router[0] : '/';
$active[$path] = 'active';
?>

<div class="admin-nav">
    <a class="<?=$active['admin'] ?? '';?>" href="/admin">Главная</a>
    <a class="<?=$active['admin/users'] ?? '';?>" href="/admin/users">Пользователи</a>
    <a class="<?=$active['admin/acquaintance'] ?? '';?>" href="/admin/acquaintance">Знакомство</a>
    <a class="<?=$active['admin/moderators'] ?? '';?>" href="/admin/moderators">Модераторы</a>
    <a class="<?= (strpos($path, 'admin/news') === 0) ? 'active' : '';?>" href="/admin/news">Лента новостей</a>
    <a class="<?= (strpos($path, 'admin/master-classes') === 0) ? 'active' : '';?>" href="/admin/master-classes">Мастер-классы</a>
    <a class="<?= (strpos($path, 'admin/experts') === 0) ? 'active' : '';?>" href="/admin/experts">Время экспертов</a>
    <a class="<?= (strpos($path, 'admin/programs') === 0) ? 'active' : '';?>" href="/admin/programs">Деловая программа</a>
    <a class="<?= (strpos($path, 'admin/jury-work') === 0) ? 'active' : '';?>" href="/admin/jury-work">Работа жюри</a>
    <a class="<?= (strpos($path, 'admin/oil-english-club') === 0) ? 'active' : '';?>" href="/admin/oil-english-club">Oil English Club</a>
    <a class="<?= (strpos($path, 'admin/lounge-time') === 0) ? 'active' : '';?>" href="/admin/lounge-time">Lounge Time</a>
    <a class="<?=$active['admin/chronograph'] ?? '';?>" href="/admin/chronograph"><span>Хронограф</span> </a>
    <a class="<?= (strpos($path, 'admin/archive') === 0) ? 'active' : '';?>" href="/admin/archive">Архив мероприятий</a>
</div>