<?php
session_start();
ini_set('display_errors', 0);

// функция подключения шаблонов
require_once 'functions.php';
// класс для работы с категориями
require_once 'classes/Category.php';
// класс джля работы с формой регистрации
require_once 'classes/forms/RegistrationForm.php';
// класс для работы с пользователем
require_once 'classes/User.php';

// проверяем подключение к базе
checkConnectToDatabase();

// категории товаров
$data['product_category'] = Category::getAllCategories();

// проверка полученных данных
if (!empty($_POST)) {
    // формируем данные для объекта новой ставки
    $data_for_form = array_merge($_POST, ['image' => $_FILES['image']]);
    // создаем объект формы регистрации
    $form = new RegistrationForm($data_for_form);

    // проверяем правильность введенных данных
    if($form->validate()) {
        // получаем данные из формы
        $form_data = $form->getData();
        // исщем пользователя с веденным email
        $user = User::getUserData($form_data['email']);
        // если пользователь не найден
        if(empty($user)) {
            // формируем данные для вставке в базу
            $value = [
                'registration_date' => date("Y-m-d H:i:s"),
                'email' => $form_data['email'],
                'name' => $form_data['name'],
                'password' => password_hash($form_data['password'], PASSWORD_DEFAULT),
                'avatar' => $form_data['image'],
                'contacts' => $form_data['contacts']
            ];

            // если вставка прошла успешно
            if(User::addNewUser($value)) {
                // авторизуем пользователя
                if(User::toAuthenticate($form_data['email'], $form_data['password']));
                   header('Location: /index.php');
            } else {
                // если вставка прошла не успешно
                header('HTTP/1.0 500 Internal Server Error');
                header('Location: /500.html');
            }
        } else {
            // если пользователь найден, формируем ошибку
            $form->setError('email', 'Пользователь с таким e-mail уже существует');
        }
    }
    // если форма заполнена не корректно, получаем ошибки валидации
    $data['errors'] = $form->getErrors();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link href="../css/normalize.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

<!-- header -->
<?= includeTemplate('templates/header.php') ?>

<!-- main -->
<?php if(empty($_POST) || (count($data['errors']) !== 0))
    // если форма не была отправленна или есть ошибки валидации
    print includeTemplate('templates/sign-up.php', $data);
?>

<!-- footer -->
<?= includeTemplate('templates/footer.php', ['product_category' => $data['product_category']]) ?>

</body>
</html>