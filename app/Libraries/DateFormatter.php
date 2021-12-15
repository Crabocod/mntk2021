<?php namespace App\Libraries;

use App\Entities\Users\UserSession;

class DateFormatter
{
    private $pattern = 'd.m.Y';
    private $withRelativeDate = true;
    private $withRelativeDateTime = false;
    private $withCurrentYear = false;

    /**
     * Устанавливает паттерн для форматирования даты
     *
     * @param string $pattern
     * @return $this
     * @throws \Exception
     */
    public function setPattern(string $pattern): self
    {
        if ($pattern === '')
            throw new \Exception('Паттерн не должен быть пустым');

        $this->pattern = $pattern;
        return $this;
    }

    /**
     * Форматировать с относительной датой, например "завтра", "сегодня", "вчера".
     *
     * @param bool $is
     * @return $this
     */
    public function withRelativeDate(bool $is = true, $withTime = false): self
    {
        $this->withRelativeDate = $is;
        $this->withRelativeDateTime = $withTime;
        return $this;
    }

    /**
     * Форматировать с текущим годом
     *
     * @param bool $is
     * @return $this
     */
    public function withCurrentYear(bool $is = true): self
    {
        $this->withCurrentYear = $is;
        return $this;
    }

    public function format_1(string $date): string
    {
        $pattern = 'EEEEEE. d MMMM%s в HH:mm';
        if ($this->withCurrentYear || date('Y') !== date('Y', strtotime($date)))
            $pattern = sprintf($pattern, ' yyyy г.');
        else
            $pattern = sprintf($pattern, '');

        $result = $this->doFormat($date, $pattern);

        return $this->mbUcfirst($result);
    }

    public function format_2(string $date): string
    {
        $pattern = 'd MMMM%s';
        if ($this->withCurrentYear || date('Y') !== date('Y', strtotime($date)))
            $pattern = sprintf($pattern, ' yyyy г.');
        else
            $pattern = sprintf($pattern, '');

        return $this->doFormat($date, $pattern);
    }

    public function format_3(string $date): string
    {
        $pattern = 'd MMMM%s в HH:mm';
        if ($this->withCurrentYear || date('Y') !== date('Y', strtotime($date)))
            $pattern = sprintf($pattern, ' yyyy г.');
        else
            $pattern = sprintf($pattern, '');

        return $this->doFormat($date, $pattern);
    }

    public function format(string $date): string
    {
        return $this->doFormat($date);
    }

    private function doFormat(string $date, string $anotherPattern = null): string
    {
        $pattern = (empty($anotherPattern)) ? $this->pattern : $anotherPattern;
        if ($this->withRelativeDate) {
            $tomorrow = DateTime::byUserTimeZone(UserSession::getUser(), date('Y-m-d', strtotime('+1 day')), 'Y-m-d');
            $today = DateTime::byUserTimeZone(UserSession::getUser(), date('Y-m-d'), 'Y-m-d');
            $yesterday = DateTime::byUserTimeZone(UserSession::getUser(), date('Y-m-d', strtotime('-1 day')), 'Y-m-d');

            $time = '';
            if($this->withRelativeDateTime)
                $time = date(' в H:i', strtotime($date));
            if (date('Y-m-d', strtotime($tomorrow)) === date('Y-m-d', strtotime($date)))
                return 'Завтра'.$time;
            if (date('Y-m-d', strtotime($today)) === date('Y-m-d', strtotime($date)))
                return 'Сегодня'.$time;
            if (date('Y-m-d', strtotime($yesterday)) === date('Y-m-d', strtotime($date)))
                return 'Вчера'.$time;
        }

        $formatter = new \IntlDateFormatter('ru_RU', \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $formatter->setPattern($pattern);
        return $formatter->format(new \DateTime($date));
    }

    /**
     * @param string $str
     * @return string
     */
    private function mbUcfirst(string $str)
    {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc.mb_substr($str, 1);
    }

    public function reset()
    {
        $this->pattern = 'd.m.Y';
        $this->withRelativeDate = true;
        $this->withCurrentYear = false;
        $this->withRelativeDateTime = false;
    }
}