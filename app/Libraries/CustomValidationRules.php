<?php namespace App\Libraries;

use devsergeev\validators\InnValidator;

/**
 * Общие правила валидации
 * Также подключено в Config/Validation
 *
 * Class CustomValidationRules
 * @package App\Libraries
 */
class CustomValidationRules
{
    public $errorMessages = [];

    /**
     * Возвращает true если inn валидный, иначе false
     *
     * @param string $str
     * @return bool
     */
    public function inn(string $str)
    {
        try {
            return InnValidator::check($str);
        } catch (\Exception $e) {
            $this->errorMessages[] = $e->getMessage();
            return false;
        }
    }

    /**
     * Возвращает ошибки
     *
     * @return null
     */
    public function listErrors($template = 'templates/all/modal_errors')
    {
        if(!empty($this->errorMessages)) {
            return view($template, [
                'errors' => $this->errorMessages
            ]);
        }
    }
}