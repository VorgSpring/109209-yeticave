<?php
require_once '../../functions.php';
/**
 * Базовый класс для работы с записями в базе данных
 * Class BaseRecord
 */
abstract class BaseRecord {
    /**
     * Имя таблици
     * @var string
     */
    private $table_name;

    /**
     * Объект базы данных
     * @var DataBase
     */
    private $dbInstance;

    /**
     * Id записи в базе данных
     * @var
     */
    protected $id;

    /**
     * Получает данные, которые формирует потомок
     * @return mixed
     */
    abstract function getData();

    /**
     * BaseRecord constructor.
     * @param DataBase $dbInstance
     * @param string $table_name
     */
    public function __construct($dbInstance, $table_name) {
        $this->dbInstance = $dbInstance;
        $this->table_name = $table_name;
    }

    /**
     * Установить в значения в поле
     * @param $property
     * @param $value
     */
    public function __set($property, $value) {
        $this[$property] = $value;
    }

    /**
     * Получить значение и з поля
     * @param $property
     * @return mixed
     */
    public function __get($property) {
        if (isset($this[$property])) {
            return $this[$property];
        } else {
            return null;
        }
    }

    /**
     * Функция для вставки данных
     * @return bool
     */
    public function insert() {
        $data = getFormatArray($this->getData());
        $fields = substr(array_keys($data)[0], 0, -2);
        $values = array_values($data)[0];

        $sql = "INSERT INTO $this->table_name SET $fields";
        $this->id = $this->dbInstance->insertData($sql, $values);
        return !empty($this->id);
    }

    /**
     * Функция для обновления данных
     * @return bool
     */
    public function update() {
        return $this->dbInstance->updateData($this->table_name, $this->getData(), $this->id);
    }

    /**
     * Функция для удаления данных
     * @return bool
     */
    public function delete() {
        return $this->dbInstance->deleteData($this->table_name, ['id' => $this->id]);
    }
}
