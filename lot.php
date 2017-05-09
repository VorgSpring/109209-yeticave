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

// данные об ошибках
$data_errors_validation = [];

// данные о ставках
$my_rates = json_decode($_COOKIE['my_rates'], true);

// проверка полученных данных
if (!empty($_POST)) {
    // проверка сделанной ставки
    if (!empty($_POST['cost']) && ($_POST['cost'] > $data_ads[$_GET['id']]['price']) && is_numeric($_POST['cost'])) {
        $value = [
            'name' => $data_ads[$_GET['id']]['name'],
            'image' => $data_ads[$_GET['id']]['image_url'],
            'category' => $data_ads[$_GET['id']]['category'],
            'cost' => $_POST['cost']
        ];

        setRateCookie($value, $_GET['id']);

        header('Location: /mylots.php');
    } else {
        $data_errors_validation['cost'] = 'Некорректная ставка';
    }
}

// данные для шаблона
$data = [
    'bets' => $bets,
    'product_category' => $product_category,
    'data_ads' => $data_ads,
    'errors' => $data_errors_validation,
    'my_rates' => $my_rates
];

/**
 * Проверка на наличие cookie и авторизацию
 * @return bool
 */
function checkCookieAndAuthorization() {
    return (isset($_SESSION['user']) && empty(json_decode($_COOKIE['my_rates'], true)[$_GET['id']]));
}
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
