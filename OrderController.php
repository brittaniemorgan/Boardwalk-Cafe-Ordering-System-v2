<?php
require "DBManager.php";
require "Order.php";
require "MenuItem.php";

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
        if ($_SESSION["cart"]==null){//use menuitems instead
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

    function checkout($address,$payment,$location,$reward){
        $this->order = new Order($_SESSION['user'],$_SESSION['cart'],$address);
        $this->db->addOrder($this->order->calculatePrice($reward), $this->order->getMenuItemNames(), $location, $address, $this->order->getCustomer()->getId(), $payment);
        $_SESSION['user'] = $this->order->getCustomer();
    }

    function editOrderStatus($orderId, $newStatus){
        //should these be setters in the Order class?'
        if($newStatus == "updateReady"){
            $time = date("h:i a");
            $stmt = $this->db->getConn()->prepare("UPDATE `orders` SET `status` = 'CLSD', `end_time` = :time WHERE `id` = :orderId");
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->bindParam(':time', $time, PDO::PARAM_STR);
        
            if($stmt->execute()){
                    echo 'status updated';
                    $sorder = $this->db->orderDetails($orderId)[0];
                    $scus = $this->db->cusDetails($sorder['cusId'])[0];
                    Order::applyRewards($scus['reward points'],$sorder['total'],$sorder['cusId']);
            }else{
                    echo 'couldnt updated status';
            }
        }
        if($newStatus == "updatePrepare"){
            $stmt = $this->db->getConn()->prepare("UPDATE `orders` SET `status` = 'PREP' WHERE `id` = :orderId");
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        
            if($stmt->execute()){
                    echo 'status updated';
            }else{
                    echo 'could not update status';
            }
        }
        #$this->viewOrders();               
    }

    function updateDelivery($orderId){
          
        $stmt = $this->db->getConn()->prepare("UPDATE `orders` SET `delivered` = 'YES' WHERE `id` = :orderId");
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();
  }


}?>
<?php
#$items = $_SESSION["cart"];
if(isset($_POST["payment"]))
{
    $location = $_POST['glocation'];
    $payment = $_POST["payment"];
    if (isset($_POST["reward_p"])){
         $reward = true;}
    else{
         $reward = false;
    }
    $address = htmlspecialchars($_POST['address']);
    $OC = new OrderController();
    $OC->checkout($address,$payment,$location,$reward);
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