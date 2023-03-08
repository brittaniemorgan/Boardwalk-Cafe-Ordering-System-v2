<?php
 require "Customer.php";
 class Order {

    private static $ordernum = 1;
    private $customer;
    private $orderNum;
    private $address;
    private $status;
    private $menuitems;

    function __construct($customer, $menuitemslst, $address) {  // Constructor
        $this->customer = $customer;
        $this->orderNum = $ordernum;
        $this->address = $address;
        $this->status = "Pending";
        $this->menuitems = $menuitemslst;
        $ordernum = $ordernum + 1;

      
    }

    function getAddress(){
        return $this->address;
    }
    
    function getStatus(){
        return $this->status;
    }

    function getMenuItems(){
        return $this->menuitems;
    }

    function calculatePrice($menuitems){
        for ($i=0; $i<$menuitems.length; $i++)
            $total = menuitems[i].getPrice();
        return $total
    }

  }

?>