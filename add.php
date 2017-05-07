<?php
// функция подключения шаблонов
require_once 'functions.php';

// данные для объявления
require_once 'data/data.php';

/**
 * Регулярное выражение для проверки формата даты
 * @type string
 */
const REG_EXP = '/(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}/';

// данные о новом лоте
$data_new_lot = [];

// данные об ошибках
$data_errors_validation = [];

// проверка получения данных
if ($_POST) {
    // проверка наименования
    if (!empty($_POST['lot-name'])) {
        $data_new_lot['name'] = htmlspecialchars($_POST['lot-name']);
    } else {
        $data_errors_validation['name'] = 'Введите наименование лота';
    }

    // проверка описания
    if (!empty($_POST['message'])) {
        $data_new_lot['description'] = htmlspecialchars($_POST['message']);
    } else {
        $data_errors_validation['message'] = 'Введите описание лота';
    }

    //проверка поля начальной стоимости
    if (empty($_POST['lot-rate']) || !is_numeric($_POST['lot-rate']) || $_POST['lot-rate'] < 0) {
        $data_errors_validation['lot-rate'] = 'Некорректное значение';
    } else {
        $data_new_lot['price'] = $_POST['lot-rate'];
    }

    //проверка поля шага ставки
    if (empty($_POST['lot-step']) || !is_numeric($_POST['lot-step']) || $_POST['lot-step'] < 0) {
        $data_errors_validation['lot-step'] = 'Некорректное значение';
    } else {
        $data_new_lot['step'] = $_POST['lot-step'];
    }

    // проверка даты
    if (empty($_POST['lot-date']) || !preg_match(REG_EXP, $_POST['lot-date'])) {
        $data_errors_validation['lot-date'] = 'Введите дату в формате "дд.мм.гггг"';
    } else {
        $data_new_lot['date'] = $_POST['lot-date'];
    }

    // проверка выбранной категории
    if (!empty($_POST['category'])) {
        $is_valid_category = false;

        foreach ($product_category as $value) {
            if($value == $_POST['category']) {
                $is_valid_category = true;
            }
        }

        if($is_valid_category) {
            $data_new_lot['category'] = $_POST['category'];
        } else {
            $data_errors_validation['category'] = 'Выбрана некорректная категория';
        }

    } else {
        $data_errors_validation['category'] = 'Выберете категорию';
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
            $data_errors_validation['file'] = 'Загрузите фото в формате "jpg", "jpeg" или "png"';
        } elseif (move_uploaded_file($file['tmp_name'], $file_name)) {
            $data_new_lot['image_url'] = $file_name;
        } else {
            $data_errors_validation['file'] = 'Возникла ошибка при загрузке файла';
        }
    } else {
        $data_errors_validation['file'] = 'Возникла ошибка при загрузке файла';
    }
}

$data = [
    'product_category' => $product_category,
    'errors' => $data_errors_validation
]
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
<?php if($_POST && count($data_errors_validation) == 0)
    print includeTemplate('templates/my-lot.php', $data_new_lot);
else
    print includeTemplate('templates/add-lot.php', $data);
?>

<!-- footer -->
<?= includeTemplate('templates/footer.php', ['product_category' => $product_category]) ?>

</body>
</html>
