<?php
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
        // проверка почты
        $this->checkEmail($data['email']);
        // проверка пароля
        $this->checkInput($data['password'], 'password', 'Введите пароль');
    }
}
