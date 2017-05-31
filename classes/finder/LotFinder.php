<?php
class LotFinder extends BaseFinder {
    private $table_name = 'lots';

    public function __construct(DataBase $dbInstance){
        parent::__construct($dbInstance, $this->table_name);
    }
}