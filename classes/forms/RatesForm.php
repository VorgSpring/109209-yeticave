<?php
// базовый класс для работы с формами
require_once 'BaseForm.php';

/**
 * Класс для работы с формой ставки
 * Class RatesForm
 */
class RatesForm extends BaseForm {
    /**
     * RatesForm constructor.
     * @param $data
     */
    public function __construct($data) {
       $this->data['price'] = $data['price'];
        $this->data['start_price'] = $data['start_price'];
    }

    /**
     * Валидация формы
     * @return bool
     */
    public function validate() {
        $this->checkRate($this->data['price'], $this->data['start_price']);
        return $this->checkValid();
    }
}
