<?php
// Создает подготовленное выражение на основе готового SQL запроса и переданных данных
require_once 'mysql_helper.php';
// класс для работы с базой данных
require_once 'classes/DataBase.php';
// класс для работы с пользователем
require_once 'classes/User.php';

/**
 * Количество часов в одном дне
 * @type number
 */
const HOURS_IN_DAY = 24;

/**
 * Количество минут в одном часе
 * @type number
 */
const MINUTES_IN_HOUR = 60;

/**
 * Количество секунд в одном часе
 * @type number
 */
const SECONDS_IN_HOUR = 3600;

/**
 * Функция подключения шаблонов
 * @param {String} $path
 * @param {Array} $data
 * @return string
 */
function includeTemplate($path, $data = []) {
    if (!file_exists($path)) {
        return '';
    }

    if (!empty($data)) {
        array_walk_recursive($data, 'transformData');
    }

    ob_start();
    include $path;
    return ob_get_clean();
}

/**
 * Преобразует все теги в мнемоники
 * @param {String} $item
 */
function transformData(&$item) {
    $item = htmlspecialchars($item);
}

/**
 * Возвращает время до полуночи этого дня в формате "чч:мм"
 * @return string
 */
function lotTimeRemaining() {
    // устанавливаем часовой пояс в Московское время
    date_default_timezone_set('Europe/Moscow');

    // временная метка для полночи следующего дня
    $tomorrow = strtotime('tomorrow midnight');

    // временная метка для настоящего времени
    $now = time();

    // оставшееся время
    $remaining_time = $tomorrow - $now;

    // оставшееся время в формате (ЧЧ:ММ)
    return gmdate('H: i', $remaining_time);
}

/**
 * Возвращает время в относительном формате
 * @param $time
 * @return string
 */
function formatTime($time) {
    $time = strtotime($time);
    $now = time();

    $interval = ($now - $time) / SECONDS_IN_HOUR;

    if($interval > HOURS_IN_DAY) {
        return date('"d.m.y" в H:i', $time);
    } else if($interval < 1) {
        return (int)($interval * MINUTES_IN_HOUR) . ' минут назад';
    } else {
        return (int)$interval . ' часов назад';
    }
}

/**
 * Проверка авторизации
 */
function checkAuthorization() {
    if(!User::checkAuthenticate()) {
        header('HTTP/1.0 403 Forbiden');
        header('Location: /login.php');
    }
}

/**
 * Проверка подключения к базе данных
 * @return object
 */
function checkConnectToDatabase() {
    if(DataBase::getInstance()->getLastError() !== null) {
        header('HTTP/1.0 500 Internal Server Error');
        header('Location: /500.html');
    }
}
