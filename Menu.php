<?php

require "DBManager.php";
class Menu{

    private $db;

    function __construct()
    {
        $this->db = DBManager::getDatabase();
        
    }

    function getFullMenu(){
       return $this->db->menuInfo();
    }

    function getFoodDescription($foodID)
    {
      $results = $this->db->getFood($foodID);
#viewCart
?>
        <div> 
            <h2 id="foodName"><?= $results[0]["name"] ?></h2>
            <form id="" action="OrderController.php" method="post">
                <textarea name="foodID"  style="display: none;"><?= $foodID ?></textarea>
                <?php
        if ($results[0]["large_size"] != null):
                ?>
                    <p>Please select a meal size</p>
                    <input type="radio" name="mealSize" value="MED" id="<?= $results[0]["price"] ?>" required> Medium - $<?= $results[0]["price"] ?></input>
                    <input type="radio" name="mealSize" value="LRG" id="<?= $results[0]["large_price"] ?>"> Large - $<?= $results[0]["large_price"] ?></input>

                <?php else: ?>
                    <p name="regPrice" id="<?= $results[0]["price"] ?>"> Price $<?= $results[0]["price"] ?></p>
                <?php endif; ?>       
                <label for="comments">Comments:</label>
                <textarea name="comments"></textarea>
                <button type = "submit" name = "add-to-cart-btn">Add to Cart</button>
            </form>

        </div>
        <?php }}?>
<?php
if(isset($_GET["foodID"])){
    $menu = new Menu();
    $menu->getFoodDescription($_GET["foodID"]);
}
?>
