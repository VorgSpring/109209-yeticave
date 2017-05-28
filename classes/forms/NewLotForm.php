<?php
// базовый класс для работы с формами
require_once 'BaseForm.php';

/**
 * Класс для работы с формой добавления нового лота
 * Class NewLotForm
 */
class NewLotForm extends BaseForm {
    /**
     * Регулярное выражение для проверки формата даты
     * @type string
     */
    private const REG_EXP = '/(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}/';

    /**
     * NewLotForm constructor.
     * @param $data
     */
    public function __construct($data) {
        $this->data['name'] = $data['name'];
        $this->data['description'] = $data['description'];
        $this->data['start_price'] = $data['start_price'];
        $this->data['step_rate'] = $data['step_rate'];
        $this->data['date'] = $data['date'];
        $this->data['category'] = $data['category'];
        $this->data['image'] = $data['image'];
    }

    /**
     * Валидация формы
     * @return bool
     */
    public function validate() {
        // проверка наименования
        $this->checkInput($this->data['name'], 'name', 'Введите наименование лота');
        // проверка описания
        $this->checkInput($this->data['description'], 'description', 'Введите описание лота');
        //проверка поля начальной стоимости
        $this->checkNumberInput($this->data['start_price'], 'start_price');
        //проверка поля шага ставки
        $this->checkNumberInput($this->data['step_rate'], 'step_rate');
        // проверка даты
        $this->checkDate($this->data['date']);
        // проверка выбранной категории
        $this->checkCategory($this->data['category']);
        // проверка загружаемой фотографии
        $this->checkImage($this->data['image'], 'img/lots');

        return $this->checkValid();
    }
}
