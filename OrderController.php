<?php
require "DBManager.php";
require "Customer.php";
require "Order.php";
session_start();

class OrderController{
    private $db;
    private $order;
    private $customer;

    function __construct(){
        $this->db = DBManager::getDatabase();
        $this->customer = $_SESSION['user'];
    }

    function addOrder($itemid,$mealsize){
        $order = $this->db->getFood($itemid)[0]; 
        if ($_SESSION["cart"]==null){
            $_SESSION["cart"][0] = [$order['name'],$order['id'],$order['price'],$mealsize];
        }
        else{array_push($_SESSION["cart"],[$order['name'],$order['id'],$order['price'],$mealsize]);}  
    }

    function checkout($address,$payment,$location){
        $this->order = new Order($this->customer,$_SESSION['cart'],$address);
        $this->db->addOrder($this->order->calculatePriceb(), $this->order->getMenuItemNames(), $location, $address, $this->customer->getId(), $payment);

    }


}

#$items = $_SESSION["cart"];
if(isset($_POST["payment"]))
{
    $location = $_POST['glocation'];
    $payment = $_POST["payment"];
    $address = htmlspecialchars($_POST['address']);
    $OC = new OrderController();
    $OC->checkout($address,$payment,$location);
    unset($_SESSION['cart']);
    header('Location: index.php');
}
else{
$OC = new OrderController();
$foodID = (int) htmlspecialchars($_POST["foodID"]);
if (isset($_POST["mealSize"])){
   $size = $_POST["mealSize"];
}
else{
    $size = "REG";
}
var_dump($_SESSION['cart']);
$OC->addOrder($foodID,htmlspecialchars($size));
var_dump($_SESSION['cart']);
#$name =$results["name"];
#$price = $results["price"];
#if (isset($_POST["mealSize"])){
 #   $size = $_POST["mealSize"];
#}
#else{
 #   $size = "REG";
#}


#$comments = $_POST["comments"];
 #   if (isset($_POST['foodID'])) {
  #      $foodID = (int)$_POST['foodID'];
   #     $stmt = $conn->query("SELECT * FROM menuItems WHERE id = $foodID");
    #    $product = $stmt->fetchAll()[0];
   
    #}
    #array_push($_SESSION['cart'], $product);
    #$products = $_SESSION['cart'];
    #array_push($_SESSION['user'][2], $product);
    header('Location: index.php');  }
?>