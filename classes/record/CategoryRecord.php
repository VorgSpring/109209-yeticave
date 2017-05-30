<?php

/**
 * Класс для работы с записью категории
 * Class CategoryRecord
 */
class CategoryRecord extends BaseRecord {
    /**
     * Название категории
     * @var string
     */
    private $name;

    /**
     * CategoryRecord constructor.
     * @param DataBase $dbInstance
     * @param $name
     */
    public function __construct(DataBase $dbInstance, $name) {
        parent::__construct($dbInstance, 'category');
        // определяем поля объекта
        $this->name = $name;

        // заносим объект в базу данных
        //$this->insert();
    }

    /**
     * Получить данные о категории
     * @return array
     */
    public function getData() {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
