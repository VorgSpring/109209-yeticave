<?php
session_start();
ini_set('display_errors', 0);

// функция подключения шаблонов
require_once 'functions.php';

// проверка авторизации
checkAuthorization();

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
 * Регулярное выражение для проверки формата даты
 * @type string
 */
const REG_EXP = '/(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}/';

// проверка полученных данных
if (!empty($_POST)) {
    // проверка наименования
    if (!empty($_POST['lot-name'])) {
        $data['new_lot']['name'] = htmlspecialchars($_POST['lot-name']);
    } else {
        $data['errors']['name'] = 'Введите наименование лота';
    }

    // проверка описания
    if (!empty($_POST['message'])) {
        $data['new_lot']['description'] = htmlspecialchars($_POST['message']);
    } else {
        $data['errors']['message'] = 'Введите описание лота';
    }

    //проверка поля начальной стоимости
    if (empty($_POST['lot-rate']) || !is_numeric($_POST['lot-rate']) || $_POST['lot-rate'] < 0) {
        $data['errors']['lot-rate'] = 'Некорректное значение';
    } else {
        $data['new_lot']['start_price'] = $_POST['lot-rate'];
    }

    //проверка поля шага ставки
    if (empty($_POST['lot-step']) || !is_numeric($_POST['lot-step']) || $_POST['lot-step'] < 0) {
        $data['errors']['lot-step'] = 'Некорректное значение';
    } else {
        $data['new_lot']['step_rate'] = $_POST['lot-step'];
    }

    // проверка даты
    if (empty($_POST['lot-date']) || !preg_match(REG_EXP, $_POST['lot-date'])) {
        $data['errors']['lot-date'] = 'Введите дату в формате "дд.мм.гггг"';
    } else {
        $data['new_lot']['completion_date'] = $_POST['lot-date'];
    }

    // проверка выбранной категории
    if (!empty($_POST['category'])) {
        // получаем id выбранной категории
        $sql_for_id_category = 'SELECT id FROM category WHERE name=?';
        $data['new_lot']['category_id'] =
            $dataBase -> getData($sql_for_id_category, ['name' => $_POST['category']])[0]['id'];

        if(!empty($data['new_lot']['category_id'])) {
            $data['new_lot']['category'] = $_POST['category'];
        } else {
            $data['errors']['category'] = 'Выбрана некорректная категория';
        }

    } else {
        $data['errors']['category'] = 'Выберете категорию';
    }

    // проверка загружаемой фотографии
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $dir = 'img';

        // если директории нет, то создаем ее
        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }

        $file_name = $dir.'/'.$file['name'];
        $file_extension = strstr($file['name'], ".");

        // список допустимых форматов
        $white_list = ['.jpg', '.jpeg', '.png'];

        if (!(in_array($file_extension, $white_list))) {
            $data['errors']['file'] = 'Загрузите фото в формате "jpg", "jpeg" или "png"';
        } elseif (move_uploaded_file($file['tmp_name'], $file_name)) {
            $data['new_lot']['image_url'] = $file_name;
        } else {
            $data['errors']['file'] = 'Возникла ошибка при загрузке файла';
        }
    } else {
        $data['errors']['file'] = 'Возникла ошибка при загрузке файла';
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
if(!empty($_POST) && (count($data['errors']) === 0)) {
    // данные для вставки в таблицу
    $sql_for_new_lot = 'INSERT INTO lots SET date_created=?, name=?, description=?, image_url=?, start_price=?, 
                          completion_date=?, step_rate=?, author_id=?, category_id=?';
    $value = [
        'date_created' => date("Y-m-d H:i:s"),
        'name' => $data['new_lot']['name'],
        'description' => $data['new_lot']['description'],
        'image_url' => $data['new_lot']['image_url'],
        'start_price' => $data['new_lot']['start_price'],
        'completion_date' => date("Y-m-d H:i:s", strtotime($data['new_lot']['completion_date'])),
        'step_rate' => $data['new_lot']['step_rate'],
        'author_id' => $_SESSION['user']['id'],
        'category_id' => $data['new_lot']['category_id']
    ];

    if($dataBase -> insertData($sql_for_new_lot, $value)) {
        print includeTemplate('templates/my-lot.php', $data['new_lot']);
    } else {
        header('HTTP/1.0 501 Not Implemented');
        header('Location: /501.html');
    }
} else {
    print includeTemplate('templates/add-lot.php', $data);
}
?>

<!-- footer -->
<?= includeTemplate('templates/footer.php', ['product_category' => $data['product_category']]) ?>

</body>
</html>
