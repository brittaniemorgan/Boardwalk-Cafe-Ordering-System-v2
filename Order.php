<?php
 require_once "Customer.php";
 require_once "DBManager.php";
 class Order {

    private static $orderCount = 1;
    private $customer;
    private $orderNum;
    private $address;
    private $status;
    private $menuitems;
    private $discount;
    private $db;

    function __construct($customer, $menuitemslst, $address) {  //add discount // Constructor
        $this->customer = $customer;
        $this->address = $address;
        $this->status = "Pending";
        $this->menuitems = $menuitemslst;
        $this->db = DBManager::getDatabase();
        //$this->orderNum = self::$orderCount;
        //self::$orderCount += 1;
    }

    function getAddress(){
        return $this->address;
    }
    
    function getStatus(){
        return $this->status;
    }

    function getCustomer(){
        return $this->customer;
    }

    function getMenuItems(){
        return $this->menuitems;
    }

    function getMenuItemNames(){
        $names = "";
        foreach($this->menuitems as $item){
            $names .=  $item[1] . " " . $item[3] . ", ";

        }
        return rtrim($names,", ");
    }

    public static function applyRewards($reward,$total,$cusId){
       $newR = $reward + floor($total/1000);
       DBManager::getDatabase()->updateUserReward($newR,$cusId);
    }

   /**function calculatePriceb($menuitems){
        for ($i=0; $i<$menuitems.length; $i++)
            $total = menuitems[i].getPrice();
        return $total;
    }*/

    function calculatePrice($discount){ //add discount as parameter
        $total = 0;
        for ($i=0; $i<count($this->menuitems); $i++)
            $total += $this->menuitems[$i][2];
        if ($discount){
            $rewards = $this->customer->getRewards();
            $total -= $rewards*10;
            if ($total<0){
                $rewards = intdiv(abs($total)/10);
                $this->customer->updateRewards($rewards);
                $this->db->updateUserReward($reward,$this->customer->getId());
                return 0;
            }
            else{
                $this->customer->updateRewards(0);
                $this->db->updateUserReward(0,$this->customer->getId());
                return $total;
            }
        }
            //- getCustomer()->getRewards()*10 adjust for negative
        else{

            return $total;}
    }

  }

?>