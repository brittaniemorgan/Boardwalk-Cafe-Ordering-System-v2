<?php

class MenuItem{

    private $item;
    private $id;
    private $name;
    private $category;
    private $price;
    private $large_price;
    private $msize;
    private $lsize;
    private $image;
    private $stock;

    function __construct($item)
    {
        $this->item = $item;
        $this->id = $item['id'];
        $this->name = $item['name'];
        $this->price = $item['price'];
        $this->large_price = $item['large_prize'];
        $this->msize = $item['medium_size'];
        $this->lsize = $item['large_size'];
        $this->image = $item['image'];
        $this->stock = $item['in_stock'];
    }

    function getItem(){
        return $this->item;
    }

    function getId(){
       return $this->id;
    }


} 

?>
