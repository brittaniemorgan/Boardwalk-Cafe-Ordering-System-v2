<?php

require "DBManager.php";
class Menu{

    private $db;

    function __construct()
    {
        $this->db = new DBManager();
        
    }

    function getFullMenu(){
    }


}

?>