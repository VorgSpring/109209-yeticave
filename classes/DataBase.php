<?php
require_once '../functions.php';

/**
 * Класс для работы с базой данных
 * Class DataBase
 */
class DataBase {
    /**
     * Ресурс соединения
     * @var mysqli
     */
    private $resource;

    /**
     * Информация о последней ошибке
     * @var string|null
     */
    private $error = null;

    /**
     * Объект соединения с базой данных
     * @var DataBase|null
     */
    private static $instance = null;

    /**
     * Возвращает объект соединения с базой данных
     * @return DataBase
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * DataBase constructor.
     * Устанавливает соединение с БД
     */
    public function __construct() {
        $resource = mysqli_connect('localhost', 'root', '', 'yeticave');

        if (!$resource) {
            $this -> error = mysqli_connect_error();
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
        $prepared_statement = $this -> db_get_prepare_stmt($this -> resource, $request, $data);

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
        $prepared_statement = $this -> db_get_prepare_stmt($this -> resource, $request, $data);

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
        $format_data = getFormatArray($data);
        // получаем поля для выражения
        $update_fields = substr(array_keys($format_data)[0], 0, -2);
        // получаем значения для выражения
        $update_value = array_values($format_data)[0];

        // аналогично форматируем массив условий
        $requirement_data = getFormatArray($requirement);
        $requirement_fields = substr(array_keys($requirement_data)[0], 0, -2);
        $requirement_value = array_values($requirement_data)[0];

        // объединяем все массивы значений
        $update_data = array_merge($update_value, $requirement_value);
       //print_r($update_data);

        // формируем запрос
        $request = "UPDATE $table SET $update_fields WHERE $requirement_fields";

        // получаем подготовленное выражение
        $prepared_statement = $this -> db_get_prepare_stmt($this -> resource, $request, $update_data);

        // выполняем запрос
        if (mysqli_stmt_execute($prepared_statement)) {
            return mysqli_stmt_affected_rows($prepared_statement);
        } else {
            return false;
        }
    }

    /**
     * Функция для удаления данных
     * @param $table
     * @param $data
     * @return bool
     */
    public function deleteData($table, $data) {
        $data_field = array_keys($data)[0];
        // формируем запрос
        $request = "DELETE FROM $table WHERE $data_field=?";
        // получаем подготовленное выражение
        $prepared_statement = $this -> db_get_prepare_stmt($this -> resource, $request, $data);
        // выполняем запрос
        return mysqli_stmt_execute($prepared_statement);

    }

    /**
     * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
     *
     * @param $link mysqli Ресурс соединения
     * @param $sql string SQL запрос с плейсхолдерами вместо значений
     * @param array $data Данные для вставки на место плейсхолдеров
     *
     * @return mysqli_stmt Подготовленное выражение
     */
    private function db_get_prepare_stmt($link, $sql, $data = []) {
        $stmt = mysqli_prepare($link, $sql);

        if ($data) {
            $types = '';
            $stmt_data = [];

            foreach ($data as $value) {
                $type = null;

                if (is_int($value)) {
                    $type = 'd';
                }
                else if (is_string($value)) {
                    $type = 's';
                }
                else if (is_double($value)) {
                    $type = 'd';
                }

                if ($type) {
                    $types .= $type;
                    $stmt_data[] = $value;
                }
            }

            $values = array_merge([$stmt, $types], $stmt_data);

            $func = 'mysqli_stmt_bind_param';
            $func(...$values);
        }

        return $stmt;
    }
}
