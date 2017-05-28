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
        $this->checkInput((string)$data['search'], 'search');
    }
}
