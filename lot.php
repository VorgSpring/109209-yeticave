<?php
session_start();
ini_set('display_errors', 0);

// функция подключения шаблонов
require_once 'functions.php';
// класс для работы с категориями
require_once 'classes/Category.php';
// класс для работы с лотами
require_once 'classes/Lot.php';
// класс для работы со ставками
require_once 'classes/Rate.php';
// класс для работы с формой ставки
require_once 'classes/forms/RatesForm.php';

// проверяем подключение к базе
checkConnectToDatabase();

// категории товаров
$data['product_category'] = Category::getAllCategories();

// данные о лоте
$data['lot'] = Lot::getLot($_GET['id']);

// проверка валидности get запроса
$is_valid = is_numeric($_GET['id']) && !empty($data['lot']);

if($is_valid) {
    // получаем данные о всех ставках на текущий лот
    $data['rates'] = Rate::getAllRatesForLot($data['lot']['id']);

    // проверка полученных данных
    if (!empty($_POST)) {
        // формируем данные для объекта новой ставки
        $data_for_form = [
            'price' => $_POST['cost'],
            'start_price' => $data['lot']['start_price']
        ];
        // создаем объект формы новой ставки
        $form = new RatesForm($data_for_form);

        // проверяем правильность введенных данных
        if($form->checkValid()) {
            // получаем данные с формы
            $form_data = $form->getData();
            // формируем данные для вставке в базу
            $value = [
                'date' => date("Y-m-d H:i:s"),
                'price' => $form_data['price'],
                'user_id' => $_SESSION['user']['id'],
                'lot_id' => $data['lot']['id']
            ];

            // если вставка прошла успешно
            if(Rate::addNewRate($value)) {
                Lot::setNewPrice($value);
                header('Location: /my-lots.php');
            } else {
                // если вставка прошла не успешно
                header('HTTP/1.0 500 Internal Server Error');
                header('Location: /500.html');
            }

        } else {
            // если форма заполнена не корректно, получаем ошибки валидации
            $data['errors'] = $form->getErrors();
        }
    }

    // проверка на наличие уже сделанной ставки и авторизации
    $data['check'] = isset($_SESSION['user']) && $_SESSION['user']['id'] !== $data['rates'][0]['user_id'];
    //print_r($data);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $is_valid ? $data['lot']['name']: '404' ?></title>
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
    print includeTemplate('templates/not-found-lot.php');
?>

<!-- footer -->
<?= includeTemplate('templates/footer.php', ['product_category' => $data['product_category']]) ?>

</body>
</html>
