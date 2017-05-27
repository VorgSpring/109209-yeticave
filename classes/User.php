<?php

/**
 * Класс для работы с пользователем
 * Class User
 */
class User {

    /**
     * SQL запрос на получения информации о пользователе по email
     * @var string
     */
    private static $sql_for_search_user_email =
        'SELECT id, email, name, password, avatar FROM users WHERE email=?';

    /**
     * SQL запрос на добавление нового пользователя
     * @var string
     */
    private static $sql_for_new_user =
        'INSERT INTO users SET registration_date=?, email=?, name=?, 
              password=?, avatar=?, contacts=?';

    /**
     * Проверяет аутентифицированность текущего пользователя
     * @return bool
     */
    public static function checkAuthenticate() {
        return isset($_SESSION['user']);
    }

    /**
     * Возвращает информацию о текущем залогиненном пользователе
     * @return array
     */
    public static function getUserData() {
        if(self::checkAuthenticate()){
            return DataBase::getInstance() -> getData(self::$sql_for_search_user_email,
                ['email' => $_SESSION['user']['$email']])[0];
        }

        return [];
    }

    /**
     * Разлогинивает пользователя
     */
    public static function logout() {
        unset($_SESSION['user']);
    }

    /**
     * Выполняет аутентификацию пользователя
     * @param $email
     * @param $password
     * @return array
     */
    public static function toAuthenticate($email, $password) {
        // ищем пользователя по email
        $user = DataBase::getInstance() -> getData(self::$sql_for_search_user_email,
            ['email' => $email])[0];

        if (!empty($user)) {
            // если пользователь найден, проверяем пароль
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                return $user;
            } else {
                return ['password' => 'Неверный пароль'];
            }
        } else {
            return ['email' => 'Пользователь с таким e-mail не найден'];
        }
    }

    /**
     * Добавляет нового пользователя в базу данных
     * @param $data
     * @return bool
     */
    public static function addNewUser($data) {
        return DataBase::getInstance() ->
            insertData(self::$sql_for_new_user, $data) !== false;
    }

}
