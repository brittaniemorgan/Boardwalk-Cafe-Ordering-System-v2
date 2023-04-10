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
        $this->large_price = $item['large_price'];
        $this->msize = $item['medium_size'];
        $this->lsize = $item['large_size'];
        $this->image = $item['image'];
        $this->stock = $item['in_stock'];
        $this->category = $item['category'];
    }

    function getItem(){
        return $this->item;
    }

    function getId(){
       return $this->id;
    }

    function getCategory(){
        return $this->category;
     }

     function getName(){
        return $this->name;
     }

     function getImage(){
        return $this->image;
     }

     function getLrgPrice(){
      return $this->large_price;
   }

   function getPrice(){
      return $this->price;
   }
    
   function getMedSize(){
      return $this->msize;
   }

   function getLrgSize(){
      return $this->lsize;
   }

} 

?>