<?php
/**
 * Класс для работы с формой добавления нового лота
 * Class NewLotForm
 */
class NewLotForm extends BaseForm {
    /**
     * Регулярное выражение для проверки формата даты
     * @type string
     */
    const REG_EXP = '/(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}/';

    /**
     * NewLotForm constructor.
     * @param $data
     */
    public function __construct($data) {
        // проверка наименования
        $this->checkInput($data['name'], 'name', 'Введите наименование лота');
        // проверка описания
        $this->checkInput($data['description'], 'description', 'Введите описание лота');
        //проверка поля начальной стоимости
        $this->checkNumberInput($data['start_price'], 'start_price');
        //проверка поля шага ставки
        $this->checkNumberInput($data['step_rate'], 'step_rate');
        // проверка даты
        $this->checkDate($data['lot-date']);
        // проверка выбранной категории
        $this->checkCategory($data['category']);
        // проверка загружаемой фотографии
        $this->checkImage($data['image'], 'img/users');
    }

    /**
     * Проверяет введенную дату
     * @param $value
     */
    private function checkDate($value) {
        if(!empty($value) && preg_match(REG_EXP, $_POST['lot-date'])) {
            $this->data['completion_date'] = $value;
        } else {
            $this->errors['date'] = 'Введите дату в формате "дд.мм.гггг"';
        }
    }

    /**
     * Проверяет выбранную категорию
     * @param $name
     */
    private function checkCategory($name) {
        if(!empty($name)) {
            $id = Category::getCategoryId($name);
            if(!empty($id)) {
                $this->data['category_id'] = $id;
            }
        } else {
            $this->errors['category'] = 'Выберете категорию';
        }

    }
}
