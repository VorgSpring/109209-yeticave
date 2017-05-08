<?php
session_start();

// функция подключения шаблонов
require_once 'functions.php';

// данные для объявления
require_once 'data/data.php';

$is_valid = false;

if(is_numeric($_GET['id']) && array_key_exists($_GET['id'], $data_ads)) {
    $is_valid = true;
}

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
        return ($interval * MINUTES_IN_HOUR) . ' минут назад';
    } else {
        return $interval . ' часов назад';
    }
}

$data = [
    'bets' => $bets,
    'product_category' => $product_category,
    'data_ads' => $data_ads
]
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $is_valid ? $data['data_ads'][$_GET['id']]['name']: '404' ?></title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<!-- header -->
<?= includeTemplate('templates/header.php') ?>

<!-- main -->
<?php if($is_valid)
    print includeTemplate('templates/lot.php', $data);
else
    print includeTemplate('templates/404.php', ['product_category' => $product_category]);
?>

<!-- footer -->
<?= includeTemplate('templates/footer.php', ['product_category' => $product_category]) ?>

</body>
</html>
