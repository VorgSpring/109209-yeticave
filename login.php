<?php
session_start();
ini_set('display_errors', 0);

// функция подключения шаблонов
require_once 'functions.php';
// класс для работы с категориями
require_once 'classes/Category.php';
// класс для работы с пользователем
require_once 'classes/User.php';
// класс для работы с формой авторизации
require_once 'classes/forms/AuthorizationForm.php';

// проверяем подключение к базе
checkConnectToDatabase();

// категории товаров
$data['product_category'] = Category::getAllCategories();

// проверка полученных данных
if (!empty($_POST)) {
    // создаем объект формы авторизации
    $form = new AuthorizationForm($_POST);
    // проверяем правильность введенных данных
    if($form->checkValid()) {
        // получаем данные с формы
        $form_data = $form->getData();
        // выполняем аутентификацию пользователя
        $errors_authenticate = User::toAuthenticate($form_data['email'], $form_data['password']);
        // если аутентификация прошла успешно
        if(empty($errors_authenticate)) {
            header("Location: /index.php");
        } else {
            // если аутентификация прошла не успешно
            $data['errors'] = $errors_authenticate;
        }
    } else {
        // получаем ошибки валидации
        $data['errors'] = $form->getErrors();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<!-- header -->
<?= includeTemplate('templates/header.php') ?>

<!-- main -->
<?php if(empty($_POST) || (count($data['errors']) !== 0))
    print includeTemplate('templates/login.php', $data);
?>

<!-- footer -->
<?= includeTemplate('templates/footer.php', ['product_category' => $data['product_category']]) ?>

</body>
</html>

