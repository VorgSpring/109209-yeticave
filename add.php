<?php
session_start();
ini_set('display_errors', 0);

// функция подключения шаблонов
require_once 'functions.php';
// класс для работы с категориями
require_once 'classes/Category.php';
// класс для работы с лотами
require_once 'classes/Lot.php';
// класс джля работы с формой регистрации
require_once 'classes/forms/NewLotForm.php';

// проверка авторизации
checkAuthorization();

// проверяем подключение к базе
checkConnectToDatabase();

// категории товаров
$data['product_category'] = Category::getAllCategories();
// объект формы
$form = null;

if (!empty($_POST)) {
    // формируем данные для объекта новой ставки
    $data_for_form = array_merge($_POST, ['image' => $_FILES['image']]);
    // создаем объект формы добавления нового лота
    $form = new NewLotForm($data_for_form);

    // проверяем правильность введенных данных
    if($form->validate()) {
        // получаем данные из формы
        $form_data = $form->getData();
        // формируем данные для вставке в базу
        $data['new_lot'] = [
            'date_created' => date("Y-m-d H:i:s"),
            'name' => $form_data['name'],
            'description' => $form_data['description'],
            'image_url' => $form_data['image'],
            'start_price' => $form_data['start_price'],
            'completion_date' => date("Y-m-d H:i:s", strtotime($form_data['completion_date'])),
            'step_rate' => $form_data['step_rate'],
            'author_id' => $_SESSION['user']['id'],
            'category_id' => $form_data['category_id']
        ];

        // если вставка прошла успешно
        if(Lot::createNewLot($data['new_lot'])) {
            // добавляем имя категории в объект
            $data['new_lot']['category'] = $form_data['category'];
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
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление лота</title>
    <link href="../css/normalize.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

<!-- header -->
<?= includeTemplate('templates/header.php') ?>

<!-- main -->
<?php
if(!empty($_POST) && $form->checkValid()) {
    print includeTemplate('templates/my-lot.php', $data['new_lot']);
} else {
    print includeTemplate('templates/add-lot.php', $data);
}
?>

<!-- footer -->
<?= includeTemplate('templates/footer.php', ['product_category' => $data['product_category']]) ?>

</body>
</html>
