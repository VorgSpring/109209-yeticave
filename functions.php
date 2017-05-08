<?php
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
