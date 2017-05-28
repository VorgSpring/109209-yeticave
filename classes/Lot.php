<?php
/**
 * Класс для работы с лотами
 * Class Lot
 */
class Lot {
    /**
     * SQL запрос на получения информации о лоте по id
     * @var string
     */
    private static $sql_for_lot = 'SELECT lots.name, lots.id, lots.image_url, lots.start_price, 
          lots.completion_date, lots.description, category.name AS category FROM lots 
                JOIN category ON lots.category_id = category.id 
                      WHERE lots.id=?';

    /**
     * SQL запрос на получения информации о лотах по id сатегории
     * @var string
     */
    private static $sql_for_lots = 'SELECT lots.id, lots.name, lots.image_url, lots.start_price,
          lots.completion_date, category.name AS category FROM lots 
                JOIN category ON lots.category_id = category.id WHERE category.id=?';

    /**
     * SQL запрос на получения информации о всех лотах
     * @var string
     */
    private static $sql_for_all_lots = 'SELECT lots.id, lots.name, lots.image_url, lots.start_price,
          lots.completion_date, category.name AS category FROM lots 
                JOIN category ON lots.category_id = category.id ';

    /**
     * SQL запрос на добавление нового лота
     * @var string
     */
    private static $sql_for_new_lot = 'INSERT INTO lots SET date_created=?, name=?, description=?, 
          image_url=?, start_price=?, completion_date=?, step_rate=?, author_id=?, category_id=?';

    /**
     * Возвращает информацию о лоте по id
     * @param $id
     * @return array
     */
    public static function getLot($id) {
        return DataBase::getInstance() -> getData(self::$sql_for_lot, ['lots.id' => $id])[0];
    }

    /**
     * Возвращает информацию о лоте по имени
     * @param $name
     * @return array
     */
    public static function getLotByName($name) {
        // формируем запрос
        $sql_for_lot_by_name = "SELECT lots.name, lots.id, lots.image_url, lots.start_price, 
          lots.completion_date, lots.description, category.name AS category FROM lots 
                JOIN category ON lots.category_id = category.id 
                      WHERE lots.name LIKE '%$name%'";

        return DataBase::getInstance()->getData($sql_for_lot_by_name);
    }

    /**
     * Возвращает информацию о лотах по id сатегории
     * @param $id
     * @return array
     */
    public static function getLots($id) {
        return DataBase::getInstance() -> getData(self::$sql_for_lots, ['category.id' => $id]);
    }

    /**
     * Возвращает информацию о всех лотах
     * @return array
     */
    public static function getAllLots() {
        return DataBase::getInstance() -> getData(self::$sql_for_all_lots);
    }

    /**
     * Добавляет новый лот в базу данных
     * @param $data
     * @return bool|number
     */
    public static function createNewLot($data) {
        return DataBase::getInstance() -> insertData(self::$sql_for_new_lot, $data);
    }

    /**
     * Изменяет начальную стоимость лота
     * @param $data
     * @return bool|int
     */
    public static function setNewPrice($data) {
        return DataBase::getInstance() -> updateData('lots', ['start_price' => $data['price']], ['id' => $data['lot_id']]);
    }
}
