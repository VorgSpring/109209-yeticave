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

// проверка полученных данных
if (!empty($_POST)) {
    // проверка почты
    if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = htmlspecialchars($_POST['email']);

        // ищем пользователя по email
        $sql_for_search_user_email = 'SELECT email FROM users WHERE email=?';
        $user = $dataBase -> $dataBase -> getData($sql_for_search_user_email, ['email' => $email])[0];

        if(empty($user)) {
            $data['new_user']['email'] = $email;
        } else {
            $data['errors']['email'] = 'Пользователь с таким e-mail уже существует';
        }
    }  else {
        $data['errors']['email'] = 'Введите e-mail';
    }

    // проверка пароля
    if (!empty($_POST['password'])) {
        $password = htmlspecialchars($_POST['password']);
        $data['new_user']['password'] = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $data['errors']['password'] = 'Введите пароль';
    }

    // проверка имени
    if (!empty($_POST['name'])) {
        $data['new_user']['name'] = htmlspecialchars($_POST['name']);
    } else {
        $data['errors']['name'] = 'Введите имя';
    }

    // проверка контактных данных
    if (!empty($_POST['message'])) {
        $data['new_user']['contacts'] = htmlspecialchars($_POST['message']);
    } else {
        $data['errors']['message'] = 'Введите описание лота';
    }

    // проверка загружаемой фотографии
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $dir = 'img/users';

        // если директории нет, то создаем ее
        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }

        $file_name = $dir.'/'.$file['name'];
        $file_extension = strstr($file['name'], ".");

        // список допустимых форматов
        $white_list = ['.jpg', '.jpeg', '.png'];

        if (!(in_array($file_extension, $white_list))) {
            $data['errors']['image'] = 'Загрузите фото в формате "jpg", "jpeg" или "png"';
        } elseif (move_uploaded_file($file['tmp_name'], $file_name)) {
            $data['new_user']['avatar'] = $file_name;
        } else {
            $data['errors']['image'] = 'Возникла ошибка при загрузке файла';
        }
    } else {
        $data['new_user']['avatar'] = 'img/user.jpg';
    }

    if (count($data['errors']) === 0) {
        // данные для вставки в таблицу
        $sql_for_new_user = 'INSERT INTO users SET registration_date=?, email=?, name=?, password=?, avatar=?, contacts=?';
        $value = [
            'registration_date' => date("Y-m-d H:i:s"),
            'email' => $data['new_user']['email'],
            'name' => $data['new_user']['name'],
            'password' => $data['new_user']['password'],
            'avatar' => $data['new_user']['avatar'],
            'contacts' => $data['new_user']['contacts']
        ];

        $data['new_user']['id'] = $dataBase -> insertData($sql_for_new_user, $value);

        //$data['new_user'] = $value;
        if($data['new_user']['id']) {
            $_SESSION['user'] = $data['new_user'];
            header('Location: /index.php');
        } else {
            header('HTTP/1.0 501 Not Implemented');
            header('Location: /501.html');
        }
    }
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
    print includeTemplate('templates/sign-up.php', $data);
?>

<!-- footer -->
<?= includeTemplate('templates/footer.php', ['product_category' => $data['product_category']]) ?>

</body>
</html>