<?php
    session_start();
    require("MenuItem.php");
    if (!isset($_SESSION['cart']))
    {$_SESSION['cart'] = null;}
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place an Order With Us</title>
    <link rel="stylesheet" href="index.css">
    <script src="script.js" type="module"></script>
    
</head>
<body>

    <div id="overLay">
        <div id="popUp">
            <div id="item-description"></div>
            <button id="close-btn"> Close</button>
        </div>
    </div>

        <header>
            <span id="expandBtn" style="font-size:30px;cursor:pointer;color:white;" >&#9776;</span>
            <img src="images/boardWalkLogo.png" alt="boardwalk cafe's logo" id="boardwalkHeaderLogo">
    
            <br>
            <br>
            <h4 id="boardwalk-cafe">Boardwalk Caf&eacute;</h4>
            <div id="wrapper">
            <div id="myNav" class="overlay">

                <!-- Button to close the overlay navigation -->
                <a href="javascript:void(0)" id="close-menu-btn" >&times;</a>
                
                <!-- Overlay content -->
                <div class="overlay-content">
                <a href="index.php">Home</a>
                <a href="prevOrders.php">Previous Orders</a>
                <a href="https://www.instagram.com/theboardwalkcafeuwi/?hl=en">Contact</a>
                <a href="adminLogIn.php">Admin</a>
                </div>

            </div>

            <div id="contact-and-welcome">
                <h5>876-977-6205</h2>  
                <h1>WEL</h1><br><h1>COME!</h1>
            </div>          
            
        </header>

       
        <section id="menu-wrapper">
            <div id="menu-heading-wrapper">
                <h2>Menu</h2>
                <img src="images/menu-icon.png">
            </div>
        
            
            <div id="menu-items-wrapper">
                

                <?php
                    require_once 'Menu.php';
                    #require_once 'Rewards.php';
                    #turn on error reporting
                    ini_set('display_errors', 'On');
                    error_reporting(E_ALL | E_STRICT);

                    #connects to databse
                    
                    $menu = new Menu();
                    #$rewards = new Rewards($db);
                    
                    #goes through each menu item and prints its data
                    $results = $menu->getFullMenu();?>
                    
                    <div>
            
                    <?php
                        #iterates through each row of the data base
                        for ($x = 0; $x < count($results); $x++){ 
                            $menuItem = new MenuItem($results[$x]);
                            #checks if item is out of stock, if it is its button is disabled and it has an out of stock message
                            if($results[$x]['in_stock'] === 'NO'){
                                #prints item category when item is the first one in the category       
                                if($x > 0 and $results[$x-1]['category'] != $menuItem->getCategory()){?>
                                    <h3 class="category-heading"><?=$menuItem->getCategory()?></h3>
                                <?php }elseif($x === 0){?>
                                    <h3 class="category-heading"><?=$menuItem->getCategory()?></h3>
                                <?php } ?>
                                        
                                
                                <button class="addToOrderButtonDisabled"  id="<?=$menuItem->getId()?>"disabled>
                                    <div class="menuItem">
                                        <img src=<?="images/".$menuItem->getImage()?> class="menuItemPic">
                            
                                        <div class="menuItemContent"  id="<?=$menuItem->getId()?>">
                                            <h5>OUT OF STOCK</h5>
                                            <h5 itemid="<?=$menuItem->getId()?>"><?=$menuItem->getName()?></h5>
                                            <div class="prices">
                                                <?php 
                                                    #checks if the item comes in a large size and prints the large size value
                                                    if(intval($menuItem->getLrgPrice()) > 0 and intval($menuItem->getPrice())> 0){?>
                                                            
                                                        <h6><?=$menuItem->getMedSize()?> - $<?=$menuItem->getPrice()?></h6>
                                                        <h6><?=$menuItem->getLrgSize()?> - $<?=$menuItem->getLrgPrice()?></h6>
                                                            
                                                            
                                                    <?php }elseif(intval($menuItem->getPrice()) > 0){?>
                                                            
                                                        <h6>Price - $<?=$menuItem->getPrice()?></h6>
                                                    <?php } ?>       
                                                                
                                                    
                                                </div>
                                        </div>
                                    </div>
                                </button>

                            <?php }else{

                            #prints item category when item is the first one in the category       
                            if($x > 0 and $results[$x-1]['category'] != $menuItem->getCategory()){?>
                                <h3 class="category-heading"><?=$menuItem->getCategory()?></h3>
                            <?php }elseif($x === 0){?>
                                <h3 class="category-heading"><?=$menuItem->getCategory()?></h3>
                            <?php } ?>
                                    
                           
                            <button class="addToOrderButton" id="<?=$menuItem->getId()?>">
                                <div class="menuItem" id="<?=$menuItem->getId()?>">
                                    <img src=<?="images/".$menuItem->getImage()?> class="menuItemPic" itemid="<?=$menuItem->getId()?>">
                        
                                    <div class="menuItemContent" id="<?=$menuItem->getId()?>" itemid="<?=$menuItem->getId()?>">
                                        
                                        <h5><?=$results[$x]['name']?></h5>
                                        <div class="prices">
                                            <?php 
                                                #checks if the item comes in a large size and prints the large size value
                                                if(intval($menuItem->getLrgPrice()) > 0 and intval($menuItem->getPrice()) > 0){?>
                                                        
                                                    <h6><?=$menuItem->getMedSize()?> - $<?=$menuItem->getPrice()?></h6>
                                                    <h6><?=$menuItem->getLrgSize()?> - $<?=$menuItem->getLrgPrice()?></h6>
                                                        
                                                        
                                                <?php }elseif(intval($menuItem->getPrice()) > 0){?>
                                                        
                                                    <h6>Price - $<?=$menuItem->getPrice()?></h6>
                                                <?php } ?>       
                                                            
                                                
                                            </div>
                                        
                                    </div>
                                </div>
                            </button>
                           
                            <?php }           
                        } ?>
                    </div>
        
            </div>
        </section>
        <button type="submit" name="finish" id="check">Ready to Checkout</button>
<!--
        <aside id="points">
            <?php
                #echo $rewards->retrieveRewardsData()." points";
            ?>
        </aside>-->
        
        <footer>
            <div>
                <a href="https://www.google.com/maps?q=boardwalk+cafe+uwi&client=safari&rls=en&sxsrf=ALiCzsaaDE19JITymRQ19W3vY_puAZNZAQ:1669570799134&uact=5&gs_lcp=Cgxnd3Mtd2l6LXNlcnAQAzIECCMQJzIECCMQJzILCC4QgAQQxwEQrwE6BwgjELADECc6CggAEEcQ1gQQsAM6BwgAELADEEM6DAguEMgDELADEEMYAToPCC4Q1AIQyAMQsAMQQxgBOhIILhDHARCvARDIAxCwAxBDGAE6EAguEIAEEIcCEMcBEK8BEBQ6BQgAEIAEOgYIABAWEB5KBAhBGABKBAhGGAFQ4gZYmwxgww5oAXABeACAAdIBiAHaBJIBBTAuMy4xmAEAoAEByAESwAEB2gEGCAEQARgI&um=1&ie=UTF-8&sa=X&ved=2ahUKEwjU5qP18877AhXiRDABHdd5AA0Q_AUoAXoECAEQAw">
                    <img src="images/location-icon.png">
                </a>

                <p>Boardwalk Caf&eacute; - UWI, Mona</p>
            </div>
            
            <div>
                <a href="https://www.facebook.com/uwiboardwalkcafe"><img src="images/facebook-logo.png"></a>
                <a href="https://www.instagram.com/theboardwalkcafeuwi/?hl=en"><img src="images/insta-logo.png"></a>
            </div>
            
        </footer>
        
    </div>
    

    

</body>
</html>