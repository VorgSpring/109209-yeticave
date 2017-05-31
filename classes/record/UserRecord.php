<?php

/**
 * Класс для работы с записью пользователей
 * Class UserRecord
 */
class UserRecord extends BaseRecord {
    /**
     * Дата регистрации пользователя
     * @var string
     */
    private $registration_date;

    /**
     * Email пользователя
     * @var
     */
    private $email;

    /**
     * Имя пользователя
     * @var
     */
    private $name;

    /**
     * Пароль пользователя
     * @var
     */
    private $password;

    /**
     * Аватар пользователя
     * @var
     */
    private $avatar;

    /**
     * Контактные данные пользователя
     * @var
     */
    private $contacts;

    /**
     * UserRecord constructor.
     * @param DataBase $dbInstance
     * @param $data
     */
    public function __construct(DataBase $dbInstance, $data) {
        parent::__construct($dbInstance, 'users');
        // определяем поля объекта
        $this->registration_date = date("Y-m-d H:i:s");
        $this->email = $data['email'];
        $this->name = $data['name'];
        $this->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->avatar = $data['avatar'];
        $this->contacts = $data['contact'];
    }

    /**
     * Получить данные о пользователе
     * @return array
     */
    public function getData() {
        return [
            'id' => $this->id,
            'registration_date' => $this->registration_date,
            'email' => $this->email,
            'name' => $this->name,
            'password' => $this->password,
            'avatar' => $this->avatar,
            'contacts' => $this->contacts
        ];
    }

    /**
     * Изменяет пароль пользователя
     * @param $password
     * @return bool
     */
    public function changePassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this->update();
    }
}
