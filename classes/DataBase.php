<?php
// Создает подготовленное выражение на основе готового SQL запроса и переданных данных
require_once 'mysql_helper.php';

class DataBase {
    /**
     * Ресурс соединения
     * @var mysqli
     */
    private $resource;

    /**
     * Информация о последней ошибке
     * @var string
     */
    private $error;

    /**
     * Устанавливает соединение с БД
     */
    public function connect() {
        $resource = mysqli_connect('localhost', 'root', '', 'yeticave');

        if (!$resource) {
            $this -> error = mysqli_connect_error();
            header('HTTP/1.0 500 Internal Server Error');
            header('Location: /500.html');
        } else {
            $this -> resource = $resource;
        }
    }

    /**
     * Возвращает информацию о последней ошибке
     * @return string
     */
    public function getLastError() {
        return $this -> error;
    }

    /**
     * Функция для получения данных
     * @param $request
     * @param array $data
     * @return array
     */
    public function getData($request, $data = []) {
        // получаем подготовленное выражение
        $prepared_statement = db_get_prepare_stmt($this -> resource, $request, $data);

        // выполняем запрос
        if(mysqli_stmt_execute($prepared_statement)) {
            $result = mysqli_stmt_get_result($prepared_statement);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    /**
     * Функция для вставки данных
     * @param $request
     * @param $data
     * @return bool|number
     */
    public function insertData($request, $data) {
        // получаем подготовленное выражение
        $prepared_statement = db_get_prepare_stmt($this -> resource, $request, $data);

        // выполняем запрос
        if(mysqli_stmt_execute($prepared_statement)) {
            return mysqli_stmt_insert_id($prepared_statement);
        } else {
            return false;
        }
    }

    /**
     * Функция для обновления данных
     * @param $table
     * @param $data
     * @param $requirement
     * @return bool|int
     */
    public function updateData($table, $data, $requirement) {
        // форматируем массив данных
        $format_data = $this -> getFormatArray($data);
        // получаем поля для выражения
        $update_fields = array_keys($format_data)[0];
        // получаем значения для выражения
        $update_value = array_values($format_data)[0];

        // аналогично форматируем массив условий
        $requirement_data = $this -> getFormatArray($requirement);
        $requirement_fields = array_keys($requirement_data)[0];
        $requirement_value = array_values($requirement_data)[0];

        // объединяем все массивы значений
        $update_data = array_merge($update_value, $requirement_value);

        // формируем запрос
        $request = "UPDATE $table SET $update_fields WHERE $requirement_fields";

        // получаем подготовленное выражение
        $prepared_statement = db_get_prepare_stmt($this -> resource, $request, $update_data);

        // выполняем запрос
        if (mysqli_stmt_execute($prepared_statement)) {
            return mysqli_stmt_affected_rows($prepared_statement);
        } else {
            return false;
        }
    }

    /**
     * Форматирует ассоциативный массив
     * переобразуя все ключи в строку, а значения в простой массив
     * @param $array
     * @return array
     */
    private function getFormatArray($array) {
        $fields = '';
        $values = [];

        foreach ($array as $key => $value) {
            $fields .= "$key=?, ";
            $values[] = $value;
        };

        return [$fields => $values];
    }

}
