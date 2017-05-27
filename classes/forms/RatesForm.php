<?php
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
        $this->checkRate($data['price'], $data['start_price']);
    }

    /**
     * Проверяет сделанную ставку
     * @param $value
     * @param $price
     */
    private function checkRate($value, $price) {
        if(!empty($value) && is_numeric($value) && $value > $price) {
            $this->data['price'] = $value;
        } else {
            $this->errors['price'] = 'Некорректная ставка';
        }
    }
}
