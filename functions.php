<?php

/**
 * Функция подключения шаблонов
 * @param {String}$path
 * @param {Array}$data
 * @return string
 */
function includeTemplate($path, $data) {
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
