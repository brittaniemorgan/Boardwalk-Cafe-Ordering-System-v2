<?php
require_once "../BusinessLogic/Customer.php";
session_start();
require_once "../Database/DBManager.php";
$db = DBManager::getDatabase();
$conn = $db -> getConn();
    $products = $_SESSION['cart'];

    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../UI/viewCart.css">
</head>
    <body>
        
        <h1 class="title-name">Boardwalk Cafe's Checkout</h1>
        <div class="Cart-Container">
            <div class="Header">
                <h3 class="Cart">Your Cart</h3>
            </div>

            <form action="../BusinessLogic/OrderController.php" method="post">
                <?php if (!$products): ?>
                    <p>You have no products added in your Shopping Cart</p>
                <?php else:?>
                <div class="Cart-Items">
                    <table>
                        <th>
                            <td>Items</td>
                            <td>Price</td>
                        </th>
                        <?php   
                            $total = 0;
                            $items = "";
                            foreach($products as $product): 
                                $total += $product[2];
                                $items .= $product[1] . " " . $product[3] . ",";
                        ?>
                        <tr>
                            <td class="name"><?=$product[0]?></td>
                        <?php if(isset($_POST['size'])){?>
                            <td ><?=$product[0]?></td>
                        <?php } 
                        else{ ?>
                            <td class="name"><?=$product[0]?> (<?=$product[3]?>)</td>
                        <?php }?>
                        <td><?=$product[2]?></td>
                        </tr>
                        <?php endforeach;?>
                        <tr></tr>
                        <tr>
                          <td class="name">Total</td>
                          <td class="name"><?=count($products)?> Items</td>
                          <td>$<?=$total?>.00</td>
                       </tr>
                    </table>
                </div>              


                
                <?php 
                   #reward points
                   # endif; 
                    #$items = rtrim($items,",");
                    $reward = $_SESSION['user']->getRewards();
                    $items = rtrim($items,",");
                ?>
                
                <div class="checkout">
                    <div class="total">
                        <div>
                            <div class="Total-checkout">Total</div>
                        </div>
                        <div class="total-value">$<?=$total?>.00</div>
                    </div>
                    <p><label for="general-location">General Location:</label></p>
                    
                    <select name="glocation" required>
                        <option value="UWI" >UWI</option>
                        <option value="Papine" >Papine</option>
                        <option value="Mona" >Mona</option>
                        <option value="Hope Pastures" >Hope Pastures</option>
                        <option value="Jamaica College" >Jamaica College</option>
                        <option value="Old Hope Road" >Old Hope Road</option>
                    </select>

                    <p><label for="payment">Payment method:</label></p>
                    <select name="payment" required>
                        <option value="CASH" >CASH</option>
                        <option value="CARD" >CARD</option>
                    </select>
                    <br>
                    <label for="reward">Apply Reward Points</label>
                    <input type="checkbox" id="reward" name="reward_p" value="<?=$reward?>">
                    <p>(Current <?=$reward?>)</p>
                    <p><label for="address">Street Address:</label></p>
                    <textarea id="address" name="address" rows="3" cols="40" required></textarea>
                    


                    <button type="submit" class="button-checkout">Checkout</button>
                </div>
                <textarea name="total" value="<?=$items?>" hidden><?=$total?></textarea>
                <textarea name="items" value="<?=$items?>" hidden><?=$items?></textarea>

            </form>
        </div>
<?php  endif; ?>
    </body>
</html>
