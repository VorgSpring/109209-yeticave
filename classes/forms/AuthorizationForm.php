<?php
// базовый класс для работы с формами
require_once 'BaseForm.php';

/**
 * Класс для работы с формой авторизации
 * Class AuthorizationForm
 */
class AuthorizationForm extends BaseForm {
    /**
     * AuthorizationForm constructor.
     * @param $data
     */
    public function __construct($data) {
        $this->data['email'] = $data['email'];
        $this->data['password'] = $data['password'];
    }

    /**
     * Валидация формы
     * @return bool
     */
    public function validate() {
        // проверка почты
        $this->checkEmail($this->data['email']);
        // проверка пароля
        $this->checkInput($this->data['password'], 'password', 'Введите пароль');

        return $this->checkValid();
    }
}
