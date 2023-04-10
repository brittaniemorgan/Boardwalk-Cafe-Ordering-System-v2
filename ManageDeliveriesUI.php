<?php
    require "OrderController.php";
    if (!isset($_SESSION['admin'])) {
        header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Personnel - The Boardwalk Cafe</title>
    <script src="ManageDeliveriesController.js"></script>
    <link rel="stylesheet" href="ManageDeliveries.css">
</head>
<body>
    <?php
        class ManageDeliveriesUI{
            private $db;
            protected $conn;
            private $role;
            private $deliveries;
            
              
            function __construct ($role) {              
              $this->db = new DBManager();
              $this->conn = $this->db->getConn();
              $this->role = $role;

              if ($this->role == "UWI Delivery"){
                $stmts = $this->conn->query("SELECT * FROM orders WHERE status = 'CLSD' AND delivered = 'NO' AND gen_del_location = 'UWI'");
                $this->deliveries = $stmts->fetchAll();
              }

              else{
                $stmts = $this->conn->query("SELECT * FROM orders WHERE status = 'CLSD' AND delivered = 'NO' AND gen_del_location != 'UWI'");
                $this->deliveries = $stmts->fetchAll();
              }

            }  




          public function viewDeliveries(){              
           ?>

            <h3>Delivery Location</h3>
            <div id="Deliveries-List">
            <?php 
            if (count($this->deliveries) < 1){
              echo "No New Deliveries";
            }
          
            foreach($this->deliveries as $delivery):
                $custId = intval($delivery['cusId']);
                $stmt = $this->conn->prepare("SELECT * FROM `users` WHERE `id` = :custId");
                $stmt->bindParam("custId", $custId, PDO::PARAM_INT);
                $stmt->execute();
                
                $customer = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                $customer = new Customer($customer['name'], $customer['id'], $customer['phoneNum'], $customer['reward points']);
                $payment = $delivery["payment"]; //need get price to work
                $genArea = $delivery["gen_del_location"];
                $cost = $delivery['total'];
                $orderNum = $delivery['id'];   //should we save a number to the database instead of having the database increment the id?
                $orderItems = [];
                foreach(explode(", ", $delivery['items']) as $item){
                  $itemID = $item[0];
                  $stmt = $this->conn->prepare("SELECT * FROM `menuitems` WHERE `id` = :itemID");
                  $stmt->bindParam("itemID", $itemID, PDO::PARAM_INT);
                  $stmt->execute();
                  array_push($orderItems, new MenuItem($stmt->fetchAll()[0]));
                }
                $delivery = new Order($delivery['cusId'],$orderItems, $delivery['address']);
              ?>

            
              
              <div class="Delivery-Div" id="DeliveryDiv-<?=$orderNum?>">
                  <h3 class="delID">Order #: <?=$orderNum?></h3>
                  <p class="delAddress">Address: <?=$delivery->getAddress()?>, <?=$genArea?></p>
                  <p class="delPrice">Total: $<?=$cost?>.00</p>
                  <p class="payment">Payment Method: <?=$payment?></p>
                  <p class="payment">Customer Contact: <?=$customer->getTelephoneNo()?></p>
                  <p class="order-statuses">Status: READY</p>
                    
                    <button id="<?=$orderNum?>" class="delivered-order">Mark as Delivered</button>
            </div> 
            <?php endforeach?>
                     
            
            </div> 
            
            
                
        <?php }
    }

    $DeliveriesUI = new ManageDeliveriesUI($_SESSION['admin'][2]);
    $DeliveriesUI->viewDeliveries();
    if (isset($_GET["orderID"])){
        echo $_GET["orderID"];
        $orderController = new OrderController();
        $orderController->updateDelivery((int)$_GET["orderID"]);
    }
    ?>
    
</body>
</html>