<?php namespace App\Libraries;

use App\Entities\Users\User;
use CodeIgniter\I18n\Time;

class DateTime
{
    /**
     * Возвращает отформатированную дату с русской локализацией.
     * Если передать объект пользователя 2 параметром то вернет дату со смещением по часовому поясу
     * пользователя.
     *
     * @param $date
     * @param $pattern
     * @param User|null $byUserTimeZone - Объект пользователя класса App\Entities\Users\User;
     * @param string $currentDateFormat - Формат переданной даты в 1 параметре. По умолчанию Y-m-d H:i:s
     * @return false|string
     */
    public static function formatRu($date, $pattern, User $byUserTimeZone = null, $currentDateFormat = 'Y-m-d H:i:s')
    {
        try {
            if($byUserTimeZone !== null)
                $date = self::byUserTimeZone($byUserTimeZone, $date, $currentDateFormat);
            $dateTime = new \DateTime($date);
            $formatter = new \IntlDateFormatter('ru_RU', \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
            $formatter->setPattern($pattern);
            return $formatter->format($dateTime);
            
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Возващает дату со смещением по часовому поясу пользователя.
     *
     * @param User $user
     * @param $date
     * @param string $format
     * @return Time|false
     */
    public static function byUserTimeZone(User $user, $date, $format = 'Y-m-d H:i:s')
    {
        try {
            if(!isset($user->timezone))
                $user->timezone = app_timezone();

            $time = Time::createFromFormat($format, $date, app_timezone());
            return $time->setTimezone($user->timezone);

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Работает как strtotime но с отличием.
     * Если передать только объект пользователя то вернет текущую временную метку по его часовому поясу.
     * Если передать $date то вернет временную метку этой даты со смещением по часовому поясу.
     *
     * @param User $user
     * @param null $date
     * @return Time|false
     */
    public static function timeByUserTimeZone(User $user, $date = null, $format = 'Y-m-d H:i:s')
    {
        try {
            if(!isset($user->timezone))
                $user->timezone = app_timezone();
            if($date !== null)
                $time = Time::createFromFormat($format, $date, app_timezone());
            else
                $time = Time::createFromTimestamp(time(), app_timezone());

            return $time->setTimezone($user->timezone)->getTimestamp();

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Возвращает системное время со смещением по часовому поясу пользователя.
     *
     * @param User $user
     * @param $date
     * @param string $format
     * @return Time|false
     */
    public static function fromUserTimeZone(User $user, $date, $format = 'Y-m-d H:i:s')
    {
        try {
            if(!isset($user->timezone))
                $user->timezone = app_timezone();

            $time = Time::createFromFormat($format, $date, $user->timezone);
            return $time->setTimezone(app_timezone());

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Установка времени к дате.
     *
     * @param $date - Любой формат даты который сможет обработать DateTime
     * @param $time - Время в формате H:i:s
     * @return mixed
     */
    public static function setTime($date, $time)
    {
        $time = explode(':', $time);
        $datetime = new \DateTime($date);
        $datetime->setTime($time[0], @$time[1], @$time[2]);
        return $datetime->format('Y-m-d H:i:s');
    }
}