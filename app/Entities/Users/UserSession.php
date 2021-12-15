<?php namespace App\Entities\Users;

use CodeIgniter\Entity;

/**
 * Класс для управления сессией пользователя
 *
 * Class UserSession
 * @package App\Entities\Users
 */
class UserSession extends Entity
{
    /**
     * Если передать один параметр:
     * Устанавливает новую сессию пользователя
     * Если передать два параметра:
     * Устанавливает в сессию пользователя значение из 2 параметра и ключом из 1
     *
     * @param User $user
     */
    public static function set($var, $value = null)
    {
        if(empty($value)) {
            if ($var instanceof User)
                session()->set('user', $var);
        } else {
            $user = self::getUser();
            if($user !== false) {
                if(isset($user->{$var}))
                    $user->{$var} = $value;
            }
        }
    }

    /**
     * Возвращает активную сессию пользователя
     *
     * @return bool|string|null
     */
    public static function getUser()
    {
        $session = session();
        return (!empty($session->user)) ? $session->user : false;
    }

    /**
     * Проверка обязательных параметров сессии
     *
     * Если отправлен объект пользователя, сверяет его с сессией и выводит true в случае успеха
     * Если не отправлен, выводит true если сессия существует
     * Иначе false
     *
     * @param User|null $user
     * @return bool
     */
    public static function checkSession(?User $user)
    {
        if (!self::checkVar($user, 'email'))
            return false;
        if (!self::checkVar($user, 'password'))
            return false;
        if (!self::checkVar($user, 'role_id'))
            return false;
        return true;
    }

    public static function checkVar(?User $user, string $var)
    {
        $userSession = self::getUser();
        if(!isset($user->{$var})) return false;
        if(!isset($userSession->{$var})) return false;
        return $user->{$var} === $userSession->{$var};
    }

    /**
     * Удаляет активную сесссию пользователя
     *
     * @return bool
     */
    public static function delete()
    {
        $session = session();
        if (isset($session->user))
            $session->remove('user');
        return true;
    }
}