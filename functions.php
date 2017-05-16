<?php
// Создает подготовленное выражение на основе готового SQL запроса и переданных данных
require_once 'mysql_helper.php';

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
 * Ищет пользователя с переданным $email в массиве $users
 * @param {String} $email
 * @param {Array} $users
 * @return null|array
 */
function searchUserByEmail($email, $users) {
    $result = null;
    foreach ($users as $user) {
        if ($user['email'] == $email) {
            $result = $user;
            break;
        }
    }
    return $result;
}

/**
 * Возвращает время в относительном формате
 * @param $time
 * @return string
 */
function formatTime($time) {
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
 * Добавляет новую cookie для новой ставки
 * @param $value
 * @param $id
 */
function setRateCookie($value, $id) {
    $my_rates = json_decode($_COOKIE['my_rates'], true);

    $data = [
        'image' => $value['image'],
        'name' => $value['name'],
        'cost' => $value['cost'],
        'id' => $id,
        'time' => time()
    ];

    $my_rates[$id] = $data;

    setcookie('my_rates', json_encode($my_rates), strtotime("tomorrow midnight"));
}

/**
 * Проверка авторизации
 */
function checkAuthorization() {
    if (!isset($_SESSION['user'])) {
        header('HTTP/1.0 403 Forbiden');
        header('Location: /login.php');
    }
}

/**
 * Функция для получения данных
 * @param $resource
 * @param $request
 * @param array $data
 * @return array
 */
function getData($resource, $request, $data = []) {
    // получаем подготовленное выражение
    $prepared_statement = db_get_prepare_stmt($resource, $request, $data);

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
 * @param $resource
 * @param $request
 * @param $data
 * @return bool|number
 */
function insertData($resource, $request, $data) {
    // получаем подготовленное выражение
    $prepared_statement = db_get_prepare_stmt($resource, $request, $data);

    // выполняем запрос
    if(mysqli_stmt_execute($prepared_statement)) {
        return mysqli_stmt_insert_id($resource);
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
function getFormatArray($array) {
    $fields = '';
    $value = [];

    foreach ($array as $key => $value) {
        $fields .= "`$key`=?, ";
        $value[] = $value;
    };

    return [$fields => $value];
}

/**
 * Функция для обновления данных
 * @param $resource
 * @param $table
 * @param $data
 * @param $requirement
 * @return bool|int
 */
function updateData($resource, $table, $data, $requirement) {
    // форматируем массив данных
    $format_data = getFormatArray($data);
    // получаем поля для выражения
    $update_fields = array_keys($format_data)[0];
    // получаем значения для выражения
    $update_value = array_values($format_data)[0];

    // аналогично форматируем массив условий
    $requirement_data = getFormatArray($requirement);
    $requirement_fields = array_keys($requirement_data)[0];
    $requirement_value = array_values($requirement_data)[0];

    // объединяем все массивы значений
    $update_data = array_merge($update_value, $requirement_value);

    // формируем запрос
    $request = "UPDATE $table SET $update_fields WHERE $requirement_fields";

    // получаем подготовленное выражение
    $prepared_statement = db_get_prepare_stmt($resource, $request, $update_data);

    // выполняем запрос
    if (mysqli_stmt_execute($prepared_statement)) {
        return mysqli_stmt_affected_rows($prepared_statement);
    } else {
        return false;
    }
}
