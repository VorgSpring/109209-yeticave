<?php
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