<?php
// функция подключения шаблонов
require_once 'functions.php';
// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// временная метка для полночи следующего дня
$tomorrow = strtotime('tomorrow midnight');

// временная метка для настоящего времени
$now = time();

// оставшееся время
$remaining_time = $tomorrow - $now;

// оставшееся время в формате (ЧЧ:ММ)
$lot_time_remaining = gmdate('H: i', $remaining_time);

// категории товаров
$product_category = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

// данные для объявления
$data_ads = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи', 'price' => 10999,
        'image_url' => 'img/lot-1.jpg'
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 159999,
        'image_url' => 'img/lot-2.jpg'
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => 10999,
        'image_url' => 'img/lot-3.jpg'],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => 10999,
        'image_url' => 'img/lot-4.jpg'
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => 10999,
        'image_url' => 'img/lot-5.jpg'],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => 10999,
        'image_url' => 'img/lot-6.jpg'
    ]
];

$data = [
    'product_category' => $product_category,
    'data_ads' => $data_ads,
    'lot_time_remaining' => $lot_time_remaining
]
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<!-- header -->
<?= includeTemplate('templates/header.php') ?>

<!-- main -->
<?= includeTemplate('templates/main.php', $data) ?>

<!-- footer -->
<?= includeTemplate('templates/footer.php') ?>

</body>
</html>