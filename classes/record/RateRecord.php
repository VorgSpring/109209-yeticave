<?php

/**
 * Класс для работы с записью ставок
 * Class RateRecord
 */
class RateRecord extends BaseRecord {
    /**
     * Дата ставки
     * @var string
     */
    private $date;

    /**
     * Ставка
     * @var
     */
    private $price;

    /**
     * Id пользователя сделавшего ставку
     * @var
     */
    private $user_id;

    /**
     * Id лота на который сделана ставка
     * @var
     */
    private $lot_id;

    /**
     * RateRecord constructor.
     * @param DataBase $dbInstance
     * @param $data
     */
    public function __construct(DataBase $dbInstance, $data) {
        parent::__construct($dbInstance, 'rates');
        // определяем поля объекта
        $this->date = date("Y-m-d H:i:s");
        $this->price = $data['price'];
        $this->user_id = $data['user_id'];
        $this->lot_id = $data['lot_id'];
    }

    /**
     * Получить данные о ставке
     * @return array
     */
    public function getData() {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'price' => $this->price,
            'user_id' => $this->user_id,
            'lot_id' => $this->lot_id
        ];
    }
}
