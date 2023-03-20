<?php
require "DBManager.php";
require "Customer.php";
require "Order.php";
session_start();

class OrderController{
    private $db;
    private $order;

    function __construct(){
        $this->db = DBManager::getDatabase();
    }

    function deleteOrder($orderId){
        $this->db->deleteOrder($orderId);
    }

    function addOrder($itemid,$mealsize){
        $order = $this->db->getFood($itemid)[0]; 
        if ($_SESSION["cart"]==null){
            $_SESSION["cart"][0] = [$order['name'],$order['id'],$order['price'],$mealsize];
        }
        else{array_push($_SESSION["cart"],[$order['name'],$order['id'],$order['price'],$mealsize]);}  
    }

    function cusOrders(){
        $cusId = $_SESSION['user']->getId();
        $conn = $this->db->getConn(); 
        $stmt = $conn->query("SELECT * FROM orders WHERE cusId = $cusId ORDER BY status DESC");//dbManager?
        return $stmt->fetchAll();
    }

    function checkout($address,$payment,$location){
        $this->order = new Order($_SESSION['user'],$_SESSION['cart'],$address);
        $this->db->addOrder($this->order->calculatePriceb(), $this->order->getMenuItemNames(), $location, $address, $this->order->getCustomer()->getId(), $payment);

    }


}?>
<?php
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
elseif(isset($_POST["add-to-cart-btn"])){
$OC = new OrderController();
$foodID = (int) htmlspecialchars($_POST["foodID"]);
if (isset($_POST["mealSize"])){
   $size = $_POST["mealSize"];
}
else{
    $size = "REG";
}
//var_dump($_SESSION['cart']);
$OC->addOrder($foodID,htmlspecialchars($size));

header('Location: index.php');  }
    ?>