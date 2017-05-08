<?php
session_start();
// функция подключения шаблонов
require_once 'functions.php';

// проверка авторизации
checkAuthorization();

// данные для объявления
require_once 'data/data.php';

// данные для шаблона
$data = [
    'product_category' => $product_category,
    'my_rates' => json_decode($_COOKIE['my_rates'], true)
];

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои ставки</title>
    <link href="../css/normalize.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

<!-- header -->
<?= includeTemplate('templates/header.php') ?>

<!-- main -->
<?= includeTemplate('templates/my-lots.php', $data) ?>

<!-- footer -->
<?= includeTemplate('templates/footer.php', ['product_category' => $product_category]) ?>

</body>
</html>
