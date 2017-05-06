<?php
// функция подключения шаблонов
require_once 'functions.php';

// данные для объявления
require_once 'data/data.php';

$data = [
    'product_category' => $product_category,
    'data_ads' => $data_ads
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
<?= includeTemplate('templates/header.php', ['is_start_page' => true]) ?>

<!-- main -->
<?= includeTemplate('templates/main.php', $data) ?>

<!-- footer -->
<?= includeTemplate('templates/footer.php') ?>

</body>
</html>