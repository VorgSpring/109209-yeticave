<?php
require_once 'DataBase.php';

class User {
    /**
     * Данные о пользователе
     * @var array
     */
    private $user_data = [];

    /**
     * Экземпляр класса DataBase
     * @var DataBase|null
     */
    private $dataBase = null;

    /**
     * Данные об ошибках
     * @var array
     */
    public $login_errors = [];

    /**
     * User constructor.
     */
    function __construct() {
        $this -> dataBase = new DataBase();
        $this -> dataBase -> connect();
    }

    /**
     * Выполняет аутентификацию пользователя
     * @param $email
     * @param $password
     */
    public function toAuthenticate($email, $password) {
        // ищем пользователя по email
        $sql_for_search_user_email = 'SELECT id, email, name, password, avatar FROM users WHERE email=?';
        $this -> user_data = $this -> dataBase -> getData($sql_for_search_user_email, ['email' => $email])[0];

        if (!empty($this -> user_data)) {
            // если пользователь найден, проверяем пароль
            if (password_verify($password, $this -> user_data['password'])) {
                $_SESSION['user'] = $this -> user_data;
            } else {
                $this -> login_errors['password'] = 'Неверный пароль';
            }
        } else {
            $this -> login_errors['email'] = 'Пользователь с таким e-mail не найден';
        }

        $this -> getUserData();
    }

    /**
     * Проверяет аутентифицированность текущего пользователя
     * @return bool
     */
    public function checkAuthenticate() {
        if (!isset($_SESSION['user'])) {
            return false;
        }
        return $_SESSION['user']['id'] === $this -> user_data['id'];
    }

    /**
     * Возвращает информацию о текущем залогиненном пользователе
     * @return array
     */
    public function getUserData() {
        return $this -> user_data;
    }

    /**
     * Разлогинивает пользователя
     */
    public function logout() {
        unset($_SESSION['user']);
        $this -> user_data = [];
    }
}
