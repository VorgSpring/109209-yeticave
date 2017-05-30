<?php
class UserFinder extends BaseFinder {
    private $table_name = 'users';

    public function __construct(DataBase $dbInstance){
        parent::__construct($dbInstance, $this->table_name);
    }
}
