<?php
// базовый класс для работы с формами
require_once 'BaseForm.php';

/**
 * Класс для работы с формой поиска
 * Class SearchForm
 */
class SearchForm extends BaseForm {
    /**
     * SearchForm constructor.
     * @param $data
     */
    public function __construct($data) {
        $this->data['search'] = $data['search'];
    }

    /**
     * Валидация формы
     * @return bool
     */
    public function validate() {
        $this->checkInput($this->data['search'], 'search');
        return $this->checkValid();
    }
}
