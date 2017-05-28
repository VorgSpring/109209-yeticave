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
     */
    public function __construct($data) {
        $this->data['email'] = $data['email'];
        $this->data['password'] = $data['password'];
        $this->data['name'] = $data['name'];
        $this->data['contacts'] = $data['contacts'];
        $this->data['image'] = $data['image'];
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
        // проверка имени
        $this->checkInput($this->data['name'], 'name', 'Введите имя');
        // проверка контактных данных
        $this->checkInput($this->data['contacts'], 'contacts', 'Введите контакты');
        // проверка загружаемой фотографии
        $this->checkImage($this->data['image'], 'img/users');

        return $this->checkValid();
    }
}
