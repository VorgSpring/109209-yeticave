<?php

/**
 * Базовый класс для работы с формами
 * Class BaseForm
 */
class BaseForm {
    /**
     * Допустимые форматы для изображений
     * @var array
     */
    private static $acceptable_formats_for_images = ['.jpg', '.jpeg', '.png'];

    /**
     * Поле с ошибками валидации
     * @var array
     */
    protected $errors = [];

    /**
     * Поле с данными формы
     * @var array
     */
    protected $data = [];

    /**
     * Проверяет email
     * @param $email
     */
    protected function checkEmail($email) {
        if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->data['email'] = htmlspecialchars($email);
        } else {
            $this->errors['email'] = 'Введите e-mail';
        }
    }

    /**
     * Проверяет поле
     * @param $field_name
     * @param $value
     * @param  $error_value
     */
    protected function checkInput($value, $field_name, $error_value = 'Необходимо заполнить это поле') {
        if (!empty($value)) {
            $this->data[$field_name] = htmlspecialchars($value);
        } else {
            $this->errors[$field_name] = $error_value;
        }
    }

    /**
     * Проверяет числовое поле
     * @param $value
     * @param $field_name
     */
    protected function checkNumberInput($value, $field_name) {
        if(!empty($value) && is_numeric($value) && $value > 0) {
            $this->data[$field_name] = $value;
        } else {
            $this->errors[$field_name] = 'Некорректное значение';
        }
    }

    /**
     * Проверяет и загружает изображение
     * @param $image
     * @param $path
     */
    protected function checkImage($image, $path) {
        // если директории нет, то создаем ее
        if (!file_exists($path)) {
            mkdir($path, 0777);
        }

        $image_name = $path . '/' . $image['name'];
        $image_extension = strstr($image['name'], ".");

        if (!(in_array($image_extension, self::$acceptable_formats_for_images))) {
            $this->errors['image'] = 'Загрузите фото в формате "jpg", "jpeg" или "png"';
        } elseif (move_uploaded_file($image['tmp_name'], $image_name)) {
            $this->data['image'] = $image_name;
        } else {
            $this->errors['image'] = 'Возникла ошибка при загрузке файла';
        }
    }

    /**
     * Проверяет введенную дату
     * @param $value
     */
    protected function checkDate($value) {
        if(!empty($value) && preg_match(self::REG_EXP, $value)) {
            $this->data['completion_date'] = $value;
        } else {
            $this->errors['date'] = 'Введите дату в формате "дд.мм.гггг"';
        }
    }

    /**
     * Проверяет выбранную категорию
     * @param $name
     */
    protected function checkCategory($name) {
        if(!empty($name)) {
            $id = Category::getCategoryId($name);
            if(!empty($id)) {
                $this->data['category'] = $name;
                $this->data['category_id'] = $id[0]['id'];
            } else {
                $this->errors['category'] = 'Выбрана некорректная категория';
            }
        } else {
            $this->errors['category'] = 'Выберете категорию';
        }
    }

    /**
     * Проверяет сделанную ставку
     * @param $value
     * @param $price
     */
    protected function checkRate($value, $price) {
        if(!empty($value) && is_numeric($value) && $value > $price) {
            $this->data['price'] = $value;
        } else {
            $this->errors['price'] = 'Некорректная ставка';
        }
    }

    /**
     * Устанавливает ошибку
     * @param $name
     * @param $value
     */
    public function setError($name, $value) {
        $this->errors[$name] = $value;
    }

    /**
     * Возвращает данные с формы
     * @return array
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Возвращаяет ошибки валидации
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Проверяет валидацию формы
     * @return mixed
     */
    public function checkValid() {
        return empty($this->errors);
    }
}
