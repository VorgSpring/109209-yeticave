<?php
// функция подключения шаблонов
require_once 'functions.php';

// ставки пользователей
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];


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
    'bets' => $bets
]
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>DC Ply Mens 2016/2017 Snowboard</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<!-- header -->
<?= includeTemplate('templates/header.php', []) ?>

<!-- main -->
<?= includeTemplate('templates/lot.php', $data) ?>

<!-- footer -->
<?= includeTemplate('templates/footer.php', []) ?>

</body>
</html>
