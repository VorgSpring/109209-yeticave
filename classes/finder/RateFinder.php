<?php
class RateFinder extends BaseFinder {
    private $table_name = 'rates';

    public function __construct(DataBase $dbInstance){
        parent::__construct($dbInstance, $this->table_name);
    }
}
