<?php
/**
 * Класс для работы с формой регистрации
 * Class RegistrationForm
 */
class RegistrationForm extends BaseForm {
    /**
     * RegistrationForm constructor.
     * @param $data
     */
    public function __construct($data) {
        // проверка почты
        $this->checkEmail($data['email']);
        // проверка пароля
        $this->checkInput($data['password'], 'password', 'Введите пароль');
        // проверка имени
        $this->checkInput($data['name'], 'name', 'Введите имя');
        // проверка контактных данных
        $this->checkInput($data['message'], 'message', 'Введите контакты');
        // проверка загружаемой фотографии
        $this->checkImage($data['image'], 'img/users');
    }
}
