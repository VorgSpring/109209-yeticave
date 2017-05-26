<?php

/**
 * Класс для работы с категориями
 * Class Category
 */
class Category {
    /**
     * SQL запрос на получения информации о категориях товаров
     * @var string
     */
    private static $sql_for_category = 'SELECT * FROM category';

    /**
     * SQL запрос на получения категории товара по названию
     * @var string
     */
    private static $sql_for_id_category = 'SELECT id FROM category WHERE name=?';

    /**
     * Возвращает все категории товаров
     * @return array
     */
    public static function getAllCategories() {
        return DataBase::getInstance() -> getData(self::$sql_for_category);
    }

    /**
     * Возвращает id категории товара
     * @param string $name
     * @return array
     */
    public static function getCategoryId($name) {
        return DataBase::getInstance() -> getData(self::$sql_for_id_category, $name);
    }
}
