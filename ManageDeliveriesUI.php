<?php
    session_start();
    if (isset($_SESSION['deliveryPersonnel'])) {
        unset($_SESSION['deliveryPersonnel']);
        header('Location: index.php');
    }
    //need to implement functionality that shows deliveries based on who is logged in. Need Login to be finaalised first
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

      require 'Employee.php';
      require_once 'DBManager.php';
        class ManageDeliveriesUI{
            private $db;
            protected $conn;
            private $personnel;
            
              
            function __construct () {              
              $this->db = new DBManager();
              $this->conn = $this->db->getConn();
              $stmt = $this->conn->query("SELECT name FROM adminusers WHERE role = 'delivery personnel'");
              $this->personnel = $stmt->fetchAll();
            }  

            function updateStatus($orderId){
          
                $stmt = $this->conn->prepare("UPDATE `orders` SET `delivered` = 'YES' WHERE `id` = :orderId");
                $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
                $stmt->execute();
          }


          public function viewOrders(){      
            //$deliveryPersonnel = $_SESSION['admin'][1];
            //echo $_SESSION['admin'][1];
            //if ($_SESSION['admin'][1] == "Chad Williams"){}
              $stmts = $this->conn->query("SELECT * FROM orders WHERE status = 'CLSD' AND delivered = 'NO' AND deliveryPersonnel = 'Chad Williams'");
              $deliveries = $stmts->fetchAll();
            
            //elseif ($_SESSION['admin'][1] == "Jason Campbell"){}
              $stmts = $this->conn->query("SELECT * FROM orders WHERE delivered = 'NO' AND deliveryPersonnel = 'Jason Campbell' AND gen_del_location = 'Mona'");
              $delMona = $stmts->fetchAll();
                            
              $stmts = $this->conn->query("SELECT * FROM orders WHERE delivered = 'NO' AND deliveryPersonnel = 'Jason Campbell' AND gen_del_location = 'Papine'");
              $delPap = $stmts->fetchAll();
                            
              $stmts = $this->conn->query("SELECT * FROM orders WHERE delivered = 'NO' AND deliveryPersonnel = 'Jason Campbell' AND gen_del_location = 'Jamaica College'");
              $delJC = $stmts->fetchAll();
                            
              $stmts = $this->conn->query("SELECT * FROM orders WHERE delivered = 'NO' AND deliveryPersonnel = 'Jason Campbell' AND gen_del_location = 'Old Hope Road'");
              $delOldHope = $stmts->fetchAll();

              $stmts = $this->conn->query("SELECT * FROM orders WHERE delivered = 'NO' AND deliveryPersonnel = 'Jason Campbell' AND gen_del_location = 'Hope Pastures'");
              $delHopePast = $stmts->fetchAll();
                            
              $deliveries = array_merge($delMona, $delPap, $delJC, $delOldHope, $delHopePast);
            
           ?>

            <h3>Delivery Location</h3>
            <div id="Deliveries-List">
            <?php foreach($deliveries as $delivery):?>

            
              
              <div class="Delivery-Div" id="DeliveryDiv-<?=$delivery["id"]?>">

                  <?php
                    $custId = $delivery['cusId'];
                    $stmt = $this->conn->query("SELECT * FROM `users` WHERE `id` = $custId");
                    $custNum = 'N/A';
                    $cusData = $stmt->fetchAll();
                    if (count($cusData) > 0){
                      //temporary until more customers are added to db
                      $custNum = $cusData[0]['phoneNum'];
                    }

                  ?>

                  <h3 class="delID">Order #: <?=$delivery["id"]?></h3>
                  <p>Address Line 1: <?=$delivery["address"]?></p>
                  <p class="delAddress">Address Line 2: <?=$delivery["gen_del_location"]?></p>  
                  <p class="delPrice">Total: $<?=$delivery["total"]?>.00</p>
                  <p class="payment">Payment Method: <?=$delivery["payment"]?></p>
                  <p class="payment">Customer Contact: <?=$custNum?></p>
                  <p class="order-statuses">Status: READY</p>
                    
                    <button id="<?=$delivery["id"]?>" class="delivered-order">Mark as Delivered</button>
            </div> 
            <?php endforeach?>
                     
            
            </div> 
            
            
                
        <?php }
    }

    $DeliveriesUI = new ManageDeliveriesUI();
    $DeliveriesUI->viewOrders();
    if (isset($_GET["orderID"])){
        echo $_GET["orderID"];
        $DeliveriesUI->updateStatus((int)$_GET["orderID"]);
    }
    ?>
    
</body>
</html>