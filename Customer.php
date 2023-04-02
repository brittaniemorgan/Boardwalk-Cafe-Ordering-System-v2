<?php

class Customer{

  private $name;
  private $id;
  #private $address;
  private $telephoneNo;
  private $reward;

   function __construct($name, $id, $telephoneNo, $reward){
    $this->name = $name;
    $this->id = $id;
   # $this->address = $address;
    $this->telephoneNo = $telephoneNo;
    $this->reward = $reward;
  }
    function getName(){return $this->name;}
    function getId(){return $this->id;}
   # function getAddress(){return $this->address;}
    function getTelephoneNo(){return $this->telephoneNo;}
    function getRewards(){return $this->reward;}
    function updateRewards($reward){$this->reward= $reward;}

}

?>

