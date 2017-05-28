<?php
session_start();
ini_set('display_errors', 0);

// функция подключения шаблонов
require_once 'functions.php';
// класс для работы с категориями
require_once 'classes/Category.php';
// класс для работы с лотами
require_once 'classes/Lot.php';
// класс для работы с формой поиска
require_once 'classes/forms/SearchForm.php';

// проверяем подключение к базе
checkConnectToDatabase();

// категории товаров
$data['product_category'] = Category::getAllCategories();

// информация о лотах
if (!empty($_GET['category_id'])) {
    $data['data_ads'] = Lot::getLots($_GET['category_id']);
} elseif(!empty($_GET['search'])) {
    // создаем объект формы авторизации
    $form = new SearchForm($_GET);
    // проверяем правильность введенных данных
    if($form->checkValid()) {
        // получаем данные с формы
        $form_data = $form->getData();
        $data['data_ads'] = Lot::getLotByName($form_data['search']);
    }
} else {
    $data['data_ads'] = Lot::getAllLots();
}
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
<?= includeTemplate('templates/footer.php', ['product_category' => $data['product_category']]) ?>

</body>
</html>