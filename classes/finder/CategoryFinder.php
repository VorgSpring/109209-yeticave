<?php

class CategoryFinder extends BaseFinder {
    private $table_name = 'category';

    public function __construct(DataBase $dbInstance){
        parent::__construct($dbInstance, $this->table_name);
    }
}
