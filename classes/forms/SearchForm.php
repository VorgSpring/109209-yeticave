<?php
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
        $this->checkInput($data['search'], 'search');
    }
}
