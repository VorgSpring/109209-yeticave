<?php

/**
 * Класс для работы с записью лота
 * Class LotRecord
 */
class LotRecord extends BaseRecord {
    /**
     * Дата создания лота
     * @var string
     */
    private $date_created;

    /**
     * Название лота
     * @var
     */
    private $name;

    /**
     * Описание лота
     * @var
     */
    private $description;

    /**
     * Изображение лота
     * @var
     */
    private $image_url;

    /**
     * Начальная стоимость
     * @var
     */
    private $start_price;

    /**
     * Дата завершения ставок на лот
     * @var
     */
    private $completion_date;

    /**
     * Шаг ставки
     * @var
     */
    private $step_rate;

    /**
     * Количество добавлений в избранное
     * @var
     */
    private $favorites;

    /**
     * Id автора
     * @var
     */
    private $author_id;

    /**
     * Id победителя
     * @var
     */
    private $winner_id;

    /**
     * Id категории
     * @var
     */
    private $category_id;

    /**
     * LotRecord constructor.
     * @param DataBase $dbInstance
     * @param $data
     */
    public function __construct(DataBase $dbInstance, $data) {
        parent::__construct($dbInstance, 'lots');
        // определяем поля объекта
        $this->date_created = date("Y-m-d H:i:s");
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->image_url = $data['image_url'];
        $this->start_price = $data['start_price'];
        $this->completion_date = $data['completion_date'];
        $this->step_rate = $data['step_rate'];
        $this->favorites = $data['favorites'];
        $this->author_id = $data['author_id'];
        $this->winner_id = $data['winner_id'];
        $this->category_id = $data['category_id'];

        // заносим объект в базу данных
        //$this->insert();

    }

    /**
     * Получить данные о лоте
     * @return array
     */
    public function getData() {
        return [
            'id' => $this->id,
            'date_created' => $this->date_created,
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'start_price' => $this->start_price,
            'completion_date' => $this->completion_date,
            'step_rate' => $this->step_rate,
            'favorites' => $this->favorites,
            'author_id' => $this->author_id,
            'winner_id' => $this->winner_id,
            'category_id' => $this->category_id
        ];
    }

    /**
     * Изменяет стоимость лота
     * @param $price
     * @return bool
     */
    public function changePrice($price) {
        $this->start_price = $price;
        return $this->update();
    }
}
