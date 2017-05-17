<?php
session_start();
ini_set('display_errors', 0);

// функция подключения шаблонов
require_once 'functions.php';

// проверяем подключение к базе
$resource = checkConnectToDatabase();

$sql_for_category = 'SELECT * FROM category ORDER BY id';

$data['product_category'] = getData($resource, $sql_for_category);

$sql_for_lots = 'SELECT lots.id, lots.name, lots.image_url, lots.start_price, lots.completion_date, 
                    category.name AS category FROM lots JOIN category ON lots.category_id = category.id ';

$data['data_ads'] = getData($resource, $sql_for_lots);

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

<?//php print_r($data); ?>

<!-- footer -->
<?= includeTemplate('templates/footer.php', ['product_category' => $data['product_category']]) ?>

</body>
</html>