<?php
// базовый класс для работы с формами
require_once 'BaseForm.php';

/**
 * Класс для работы с формой регистрации
 * Class RegistrationForm
 */
class RegistrationForm extends BaseForm {
    /**
     * RegistrationForm constructor.
     * @param $data
     * @param $image
     */
    public function __construct($data, $image) {
        // проверка почты
        $this->checkEmail($data['email']);
        // проверка пароля
        $this->checkInput($data['password'], 'password', 'Введите пароль');
        // проверка имени
        $this->checkInput($data['name'], 'name', 'Введите имя');
        // проверка контактных данных
        $this->checkInput($data['contacts'], 'contacts', 'Введите контакты');
        // проверка загружаемой фотографии
        $this->checkImage($image, 'img/users');
    }
}
