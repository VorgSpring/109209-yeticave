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

/**
 * Регулярное выражение для проверки адреса почты
 * @type string
 */
const REG_EXP = '/.+@.+\..+/i';

// данные об ошибках
$data['errors'] = [];

// адрес почты пользователя
$email = null;

// пароль пользователя
$password = null;

// проверка полученных данных
if (!empty($_POST)) {
    // проверка почты
    if (!empty($_POST['email']) && preg_match(REG_EXP, $_POST['email'])) {
        $email = htmlspecialchars($_POST['email']);
    } else {
        $data['errors']['email'] = 'Введите e-mail';
    }

    // проверка пароля
    if (!empty($_POST['password'])) {
        $password = htmlspecialchars($_POST['password']);
    } else {
        $data['errors']['password'] = 'Введите пароль';
    }
}

// если данные введены верно
if(!is_null($email) && !is_null($password)) {
    // ищем пользователя по email
    $sql_for_search_user_email = 'SELECT id, email, name, password, avatar FROM users WHERE email=?';
    $user = $dataBase -> getData($sql_for_search_user_email, ['email' => $email])[0];
    $data['user'] = $user;
    if (!empty($user)) {
        // если пользователь найден, проверяем пароль
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: /index.php");
        } else {
            $data['errors']['password'] = 'Неверный пароль';
        }
    } else {
        $data['errors']['email'] = 'Пользователь с таким e-mail не найден';
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

