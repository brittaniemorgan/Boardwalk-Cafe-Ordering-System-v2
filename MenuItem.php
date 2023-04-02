<?php

class MenuItem{

    private $id;
    $name;
    $category;
    $price;
    $size;
    $image;

    function __construct($id,$name,$price,$category,$size,$image)
    {
        $this->id = $id;
        
    }

    function getId(){
       return $this->id;
    }


} 

?>
