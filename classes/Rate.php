<?php
/**
 * Класс для работы со ставками
 * Class Rate
 */
class Rate {
    /**
     * SQL запрос на информацию о ставках на лот
     * @var string
     */
    private static $sql_for_rates = 'SELECT rates.price, rates.date, rates.user_id, 
        users.name AS user FROM rates JOIN users ON rates.user_id = users.id 
              WHERE rates.lot_id=? ORDER BY rates.date DESC ';

    /**
     * SQL запрос на информацию о ставках сделанных пользователем
     * @var string
     */
    private static $sql_for_user_rates = 'SELECT rates.price, rates.date, rates.lot_id, 
        lots.image_url AS image, lots.name AS name FROM rates 
              JOIN lots ON rates.lot_id=lots.id WHERE rates.user_id=?';

    /**
     * SQL запрос на информацию о максимальной ставке на лот
     * @var string
     */
    private static $sql_for_max_rate = 'SELECT price AS max_price FROM rates 
        WHERE lot_id=? ORDER BY price DESC LIMIT 1';

    /**
     * Возвращает информацию о ставках на лот
     * @param $lot_id
     * @return array
     */
    public static function getAllRatesForLot($lot_id) {
        return DataBase::getInstance() -> getData(self::$sql_for_rates, $lot_id);
    }

    /**
     * Возвращает информацию о ставках сделанных пользователем
     * @param $user_id
     * @return array
     */
    public static function getUserRates($user_id) {
        return DataBase::getInstance() -> getData(self::$sql_for_user_rates, $user_id);
    }

    /**
     * Возвращает максимальную ставку на лот
     * @param $lot_id
     * @return array
     */
    public static function getMaxRate($lot_id) {
        return DataBase::getInstance() -> getData(self::$sql_for_max_rate, $lot_id);
    }
}
