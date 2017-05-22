<?php
session_start();
ini_set('display_errors', 0);

// функция подключения шаблонов
require_once 'functions.php';

// подключаем класс для работы с БД
require_once 'classes/DataBase.php';

// создаем экземпляр для работы с БД
$dataBase = new DataBase();

// проверяем подключение к базе
$dataBase -> connect();

// категории товаров
$sql_for_category = 'SELECT * FROM category';
$data['product_category'] = $dataBase -> getData($sql_for_category);

// данные о лоте
$sql_for_lot = 'SELECT lots.name, lots.id, lots.image_url, lots.start_price, lots.completion_date, lots.description,
                    category.name AS category FROM lots JOIN category ON lots.category_id = category.id 
                      WHERE lots.id=?';
$data['lot'] = $dataBase -> getData($sql_for_lot, ['lots.id' => $_GET['id']])[0];

// проверка валидности get запроса
$is_valid = is_numeric($_GET['id']) && !empty($data['lot']);

if($is_valid) {
    // данные об ошибках
    $data['errors'] = [];

    // данные о ставках
    $sql_for_rates = 'SELECT rates.price, rates.date, rates.user_id, users.name AS user FROM rates 
                        JOIN users ON rates.user_id = users.id WHERE rates.lot_id=? ORDER BY rates.date DESC ';
    $data['rates'] = $dataBase -> getData($sql_for_rates, ['rates.lot_id' => $_GET['id']]);

    // проверка полученных данных
    if (!empty($_POST)) {
        // проверка сделанной ставки
        if (!empty($_POST['cost']) && ($_POST['cost'] > $data['lot']['start_price']) && is_numeric($_POST['cost'])) {
            $value = [
                'date' => date("Y-m-d H:i:s"),
                'price' => $_POST['cost'],
                'user_id' => $_SESSION['user']['id'],
                'lot_id' => $data['lot']['id']
            ];

            // вставляем данные о новой ставке
            $sql_for_insert_rate = 'INSERT INTO rates SET date=?, price=?, user_id=?, lot_id=?';
            if ($dataBase -> insertData($sql_for_insert_rate, $value)) {
                header('Location: /mylots.php');
            } else {
                header('HTTP/1.0 501 Not Implemented');
                header('Location: /501.html');
            }

        } else {
            $data['errors']['cost'] = 'Некорректная ставка';
        }
    }

    // Проверка на наличие cookie и авторизацию
    $data['check'] = isset($_SESSION['user']) && $_SESSION['user']['id'] !== $data['rates'][0]['user_id'];
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
