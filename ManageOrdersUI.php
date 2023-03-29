<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="ManageOrders.css">
    <script src="ManageOrdersController.js"></script>
</head>


<?php
    require "OrderController.php";
    class ManageOrdersController{
        private $db;
        private $conn;
        private $stmt;
        private $orders;

        function __construct(){
            $this->db = new DBManager();
            $this->conn = $this->db->getConn();
            $this->stmt = $this->conn->query("SELECT * FROM `orders` WHERE `status` = 'OPEN' OR `status` = 'PREP' ORDER BY `id` ASC");
            $this->orders = $this->stmt->fetchAll();
            foreach($this->orders as $order){
                $order = new Order($order['cusId'],$order['items'], $order['address']);
            }
            
            
        }
        public function viewOrders(){
            
           ?>
            <div id="order-list" >
            <?php 
            foreach($this->orders as $order):
                $orderStatus = $order["status"];
                $orderNum = $order['id'];   //get this from attribute
                $order = new Order($order['cusId'],$order['items'], $order['address']);
            ?>
            
            <div class = "orderDiv" id="orderDiv<?=$orderNum?>">
                <h3>Order #<?=$orderNum?></h3>
                <ul><?php
                    $items = explode(",",$order->getMenuItems());
                    foreach($items as $item):
                        $foodID = (int) substr($item,0,2);
                        $foodItems = $this->db->getConn()->query("SELECT * FROM menuItems WHERE id =$foodID");
                        $foodResult = $foodItems->fetchAll();
                        $foodName = $foodResult[0]["name"];
                        $foodCategory = $foodResult[0]["category"];
                ?>
                    
                        <li id="<?=$orderNum?>>"><?=$foodName?>, <?=substr($item,2)?></li>
                        <p class="item-category">Category: <?=$foodCategory?></p>
                    <?php endforeach?>
                </ul>
                <p class="order-status-" id="order-status-<?=$orderNum?>">Status: <?=$orderStatus?></p>
                <button id="<?=$orderNum?>" class="mark-preparing">Mark as Preparing</button>
                <button id="<?=$orderNum?>" class="mark-ready">Mark as Ready</button>
            </div>
            <?php endforeach;?>

            </div>
            <?php
        }

        function updateStatus($orderId){
          
            $stmt = $this->conn->prepare("UPDATE `orders` SET `delivered` = 'YES' WHERE `id` = :orderId");
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->execute();
        }
            public function getOrder($orderNo){
                //not sure where to use this
                foreach($this->orders as $order){
                    if ($order['id'] == $orderNo){
                        return $order;     
                    }     
                }
            }
            
        function main(){
            $this->viewOrders();
        }
    }

    $orderManager = new ManageOrdersController();
    $orderManager->viewOrders();
 
    if (isset($_GET["orderId"]) && isset($_GET['action'])){
        $orderController = new OrderController();
        $orderController->editOrderStatus($_GET["orderId"], $_GET['action']);
    }
    ?>
    
