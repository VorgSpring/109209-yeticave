<?php
session_start();
ini_set('display_errors', 0);

// функция подключения шаблонов
require_once 'functions.php';

// проверка авторизации
checkAuthorization();

// подключаем класс для работы с БД
require_once 'classes/DataBase.php';

// создаем экземпляр для работы с БД
$dataBase = new DataBase();

// проверяем подключение к базе
$dataBase -> connect();

// категории товаров
$sql_for_category = 'SELECT * FROM category';
$data['product_category'] = $dataBase -> getData($sql_for_category);

// данные для шаблона
$sql_for_my_rates = 'SELECT rates.price, rates.date, rates.lot_id, lots.image_url AS image, lots.name AS name 
                        FROM rates JOIN lots ON rates.lot_id=lots.id WHERE rates.user_id=?';
$data['my_rates'] = $dataBase -> getData($sql_for_my_rates, ['user_id' => $_SESSION['user']['id']]);


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
