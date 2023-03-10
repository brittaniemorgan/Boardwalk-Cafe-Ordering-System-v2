<?php
session_start();
require "DBManager.php";
$db = DBManager::getDatabase();;
$conn = $db -> getConn();

    $products = $_SESSION['cart'];
    #var_dump($products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="viewCart.css">
</head>
    <body>
        
        <h1 class="title-name">Boardwalk Cafe's Checkout</h1>
        <div class="Cart-Container">
            <div class="Header">
                <h3 class="Cart">Your Cart</h3>
            </div>
            <?php  $products = $_SESSION['cart']
?>
            <form action="OrderController.php" method="post">
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
                    </table>
                </div>              


                
                <?php 
                    endif; 
                    #$items = rtrim($items,",");
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

                    <p><label for="address">Street Address:</label></p>
                    <textarea id="address" name="address" rows="3" cols="40" required></textarea>
                    


                    <button type="submit" class="button-checkout">Checkout</button>
                </div>
                <textarea name="total" value="<?=$items?>" hidden><?=$total?></textarea>
                <textarea name="items" value="<?=$items?>" hidden><?=$items?></textarea>

            </form>
        </div>

    </body>
</html>
