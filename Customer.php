<?php

class Customer{

  private $name;
  private $id;
  private $address;
  private $telephoneNo;
  private $reward;

   function __construct($name, $id, $address, $telephoneNo, $reward){
    $this->name = $name;
    $this->id = $id;
    $this->address = $address;
    $this->telephoneNo = $telephoneNo;
    $this->reward = $reward;
  }
    function getName(){return $this->name;}
    function getId(){return $this->id;}
    function getAddress(){return $this->address;}
    function getTelephoneNo(){return $this->telephoneNo;}
    function getReward(){return $this->reward;}
   #function updateRewards(){}

}

?>

