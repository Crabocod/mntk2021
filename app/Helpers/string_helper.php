<?php
/**
 * Очистка номера телефона от лишних символов
 *
 * @param $phone
 * @return string|string[]|null
 */
function get_simple_phone_number($phone)
{
    $phone = preg_replace("/\D+/", "", $phone);
    if (strlen($phone) == 10) {
        $phone = "7" . $phone;
    } else if (strlen($phone) == 11 && $phone[0] == 8) {
        $phone = substr_replace($phone, '7', 0, 1);
    }
    return $phone;
}

/**
 * Возвращает номер телефона в формате "7 (912) 345-67-98"
 *
 * @param $phone
 * @return string
 */
function get_beautiful_phone_number($phone)
{
    if (strlen($phone) == 11)
        return $phone[0] . " (" . $phone[1] . $phone[2] . $phone[3] . ") " . $phone[4] . $phone[5] . $phone[6] . "-" . $phone[7] . $phone[8] . "-" . $phone[9] . $phone[10];
    else
        return $phone;
}

/**
 * Приводим число 123.00 в 123, а 123.90 оставляем
 *
 * @param $number
 * @param bool $probel
 * @param string $sep
 * @return string
 */
function cost_format($number, $probel = true, $sep = '.')
{
    $probel = $probel ? ' ' : '';
    return rtrim(rtrim(number_format($number, 2, $sep, $probel), 0), $sep);
}
