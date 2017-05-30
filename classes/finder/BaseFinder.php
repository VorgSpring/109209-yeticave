<?php
require_once '../../functions.php';

/**
 * Базовый класс для работы с поиском
 * Class BaseFinder
 */
abstract class BaseFinder {
    /**
     * @var string
     */
    private $table_name;

    /**
     * @var DataBase
     */
    private $dbInstance;

    /**
     * BaseFinder constructor.
     * @param DataBase $dbInstance
     * @param string $table_name
     */
    public function __construct($dbInstance, $table_name) {
        $this->dbInstance = $dbInstance;
        $this->table_name = $table_name;
    }

    /**
     * Находит и возвращает один объект-запись по её первичному ключу
     * @param $id
     * @param $className
     * @return array
     */
    public function findById($id, $className) {
        $sql = "SELECT * FROM $this->table_name WHERE id=?";
        $item = $this->dbInstance->getData($sql, ['id' => $id]);
        return  new $className($item);
    }

    /**
     * Находит и возвращает список из объектов-записей по условию из ассоциативного массива
     * @param $where
     * @param $className
     * @return array
     */
    public function findAllBy($where, $className) {
        $result = [];
        $data = getFormatArray($where);
        $fields = substr(array_keys($data)[0], 0, -2);
        $values = array_values($data)[0];

        $sql = "SELECT * FROM $this->table_name WHERE $fields";

        $items = $this->dbInstance->getData($sql, $values);

        foreach ($items as $item) {
            array_push($result, new $className($item));
        }
        return $result;
    }

    /**
     * Находит и возвращает список из всех объектов-записей
     * @param $className
     * @return array
     */
    public function findAll($className) {
        $result = [];

        $sql = "SELECT * FROM $this->table_name";

        $items = $this->dbInstance->getData($sql);

        foreach ($items as $item) {
            array_push($result, new $className($item));
        }
        return $result;
    }
}
