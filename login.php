<?php
session_start();

// функция подключения шаблонов
require_once 'functions.php';

// данные для объявления
require_once 'data/data.php';

// пользователи для аутентификации
require_once 'data/userdata.php';

/**
 * Регулярное выражение для проверки адреса почты
 * @type string
 */
const REG_EXP = '/.+@.+\..+/i';

// данные об ошибках
$data_errors_validation = [];

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
        $data_errors_validation['email'] = 'Введите e-mail';
    }

    // проверка пароля
    if (!empty($_POST['password'])) {
        $password = htmlspecialchars($_POST['password']);
    } else {
        $data_errors_validation['password'] = 'Введите пароль';
    }
}

// если данные введены верно
if(!is_null($email) && !is_null($password)) {
    // ищем пользователя по email
    if ($user = searchUserByEmail($email, $users)) {
        // если пользователь найден, проверяем пароль
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: /index.php");
        } else {
            $data_errors_validation['password'] = 'Неверный пароль';
        }
    } else {
        $data_errors_validation['email'] = 'Пользователь с таким e-mail не найден';
    }
}

// данные для шаблона
$data = [
    'product_category' => $product_category,
    'errors' => $data_errors_validation
]
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
<?php if(empty($_POST) || (count($data_errors_validation) !== 0))
    print includeTemplate('templates/login.php', $data);
?>

<!-- footer -->
<?= includeTemplate('templates/footer.php', ['product_category' => $product_category]) ?>

</body>
</html>

