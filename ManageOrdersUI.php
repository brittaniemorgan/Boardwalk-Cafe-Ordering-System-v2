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
    require "DBManager.php";
    require "Order.php";
    class ManageOrdersController{
        private $db;
        private $conn;
        private $stmt;
        private $orders;

        function __construct(){
            $this->db = new DBManager();
            $this->conn = $this->db->getConn();
            $this->stmt = $this->conn->query("SELECT * FROM `orders` WHERE `status` = 'OPEN' OR `status` = 'PREP' ORDER BY `start_time` ASC");
            $this->orders = $this->stmt->fetchAll();
            foreach($this->orders as $order){
                $order = new Order($order['cusId'],$order['items'], $order['address']);
            }
            
            
        }
        public function viewOrders(){
            
           ?>
            <div id="order-list" >
            <?php 
            foreach($this->orders as $order):?>
            
            <div class = "orderDiv" id="orderDiv<?=$order["id"]?>">
                <h3>Order #<?=$order["id"]?></h3>
                <ul><?php
                    $items = explode(",",$order["items"]);
                    foreach($items as $item):
                        $foodID = (int) substr($item,0,2);
                        $foodItems = $this->db->getCOnn()->query("SELECT * FROM menuItems WHERE id =$foodID");
                        $foodResult = $foodItems->fetchAll();
                        $foodName = $foodResult[0]["name"];
                        $foodCategory = $foodResult[0]["category"];
                ?>
                    
                        <li id="<?=$order["id"]?>>"><?=$foodName?>, <?=substr($item,2)?></li>
                        <p class="item-category">Category: <?=$foodCategory?></p>
                    <?php endforeach?>
                </ul>
                <p class="order-status-" id="order-status-<?=$order["id"]?>">Status: <?=$order["status"]?></p>
                <button id="<?=$order["id"]?>" class="mark-preparing">Mark as Preparing</button>
                <button id="<?=$order["id"]?>" class="mark-ready">Mark as Ready</button>
            </div>
            <?php endforeach;?>

            </div>
            <?php
        }
            public function getOrder($orderNo){
                //not sure where to use this
                foreach($this->orders as $order){
                    if ($order['id'] == $orderNo){
                        return $order;     
                    }     
                }
            }
            
            function editOrderStatus($orderId, $newStatus){
                if($newStatus == "updateReady"){
                    $time = date("h:i a");
                    $stmt = $this->conn->prepare("UPDATE `orders` SET `status` = 'CLSD', `end_time` = :time WHERE `id` = :orderId");
                    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
                    $stmt->bindParam(':time', $time, PDO::PARAM_STR);
                
                    if($stmt->execute()){
                            echo 'status updated';
                    }else{
                            echo 'couldnt updated status';
                    }
                }
                if($newStatus == "updatePrepare"){
                    $stmt = $this->conn->prepare("UPDATE `orders` SET `status` = 'PREP' WHERE `id` = :orderId");
                    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
                
                    if($stmt->execute()){
                            echo 'status updated';
                    }else{
                            echo 'could not update status';
                    }
                }
                $this->viewOrders();               
            }
        function main(){
            $this->viewOrders();
        }
    }

    $controller = new ManageOrdersController();
    $controller->viewOrders();
    if (isset($_GET["orderId"]) && isset($_GET['action'])){
        $controller->editOrderStatus($_GET["orderId"], $_GET['action']);
    }
    ?>
    
