<?php
session_start();
ini_set('display_errors', 0);

// функция подключения шаблонов
require_once 'functions.php';
// класс для работы с категориями
require_once 'classes/Category.php';
// класс для работы с пользователем
require_once 'classes/User.php';
// класс для работы со ставками
require_once 'classes/Rate.php';

// проверка авторизации
checkAuthorization();

// проверяем подключение к базе
checkConnectToDatabase();

// категории товаров
$data['product_category'] = Category::getAllCategories();

// данные для шаблона
$data['my_rates'] = Rate::getUserRates($_SESSION['user']['id']);
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
<?= includeTemplate('templates/footer.php', ['product_category' => $data['product_category']]) ?>

</body>
</html>
