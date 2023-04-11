<script src="../BusinessLogic/prevOrders.js" type="text/javascript"></script>
<link rel="stylesheet" href="../UI/prevOrders.css">
<?php
    require_once "../BusinessLogic/OrderController.php";
    require_once "../BusinessLogic/Menu.php";
   
   // $cusId = $_SESSION['user']->getId();

    //$GLOBALS['db'] = $db;
    $oc = new OrderController();
    $menu = new Menu();
    $orders = $oc->cusOrders();
    foreach($orders as $order):
?>
    <div class="order" id="order-<?=$order["id"]?>">
        <p>Order Date: <?=$order["date"]?></p>
        <ul>
        <?php $items = explode(", ",$order['items']);
                foreach($items as $item):
                    $foodID = explode(" ", $item)[0];
                    $foodSize = explode(" ", $item)[1];
                    $foods = $menu->getFood($foodID);
                    $foodName = $foods[0]->getName();
        ?>
            <li><?=$foodName?> (<?=$foodSize?>)</li>
            <?php endforeach?>
        </ul>
        <p>Address: <?=$order['address']?>, <?=$order['gen_del_location']?></p>
        <p>Total: <?=$order['total']?></p>
        <?php if ($order['status'] == 'CLSD' && $order['delivered'] == 'NO'):?>
            <p>Status: Your order is on the way!</p>
        <?php elseif ($order['delivered'] == 'YES'):?>
            <p>Status: Your order has been delivered. Enjoy!</p>
        <?php elseif($order['status'] == 'OPEN'):?>
            <p>Status: Your order has been received.</p>
            <button class="cancel-order-btn" id="<?=$order['id']?>">Cancel</button>
        <?php elseif($order['status'] == 'PREP'):?>
            <p>Status: Your order is being prepared.</p>
            <button class="cancel-order-btn" id="<?=$order['id']?>">Cancel</button>
        <?php endif?>
    </div>
<?php endforeach;

    if (isset($_GET['orderId'])){
        $oc->deleteOrder((int) $_GET['orderId']);
    }
?>

                
        
