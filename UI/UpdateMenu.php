<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Updating Menu</title>
    
    <link rel="stylesheet" href="../UI/UpdateMenuPage.css">
    

</head>
<body>
    <?php
    /*echo $SESSION['admin'][0];
        if (!isset($SESSION["admin"])){
            //header('Location: index.php');
        }*/
        
        require_once '../Database/DBManager.php';
        require_once '../BusinessLogic/UpdateMenuController.php';

        #turn on error reporting
        ini_set('display_errors', 'On');
        error_reporting(E_ALL | E_STRICT);

        #connects to databse
        $host = 'localhost';
        $username = 'boardwalk_user';
        $password = 'password123';
        $dbname = 'cafeInfo';
        
        $db = new DBManager($host, $username, $password, $dbname);
        $manager = new UpdateMenuController();  
    ?>

    <div id="hero"> 
        <h1>Manager</h1>
    </div>

    <div id="nav-buttons">
        <a href="http://localhost/comp2171-groupproject/UI/ReportUI.php?filter=d">
            <button id="view-report">View Reports</button>
        </a>
    </div>

        
    <div id = "update-menu">
        <h2>Update Menu</h2>
        

        <h4>Current Items</h4>
        <table id="current-menu">
            <tr>
            <?php
                $results = $db->menuInfo();
                foreach($results as $row): ?>

                    <td id="small-menu"><?=$row['name'].", ".$row['category'] ?></td>
            <?php endforeach ?>
            </tr>
        </table>
        
        <!--Add to menu-->
        <h4>Add Menu Item</h4>
        <form action="../BusinessLogic/UpdateMenuController.php" method="post" id="add-form" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input id="name" name="name" type="text" maxlength="50" required placeholder="Item Name">

            <label for="category">Category:</label>
            <input name="category" type="text" maxlength="35" required placeholder="Category">

            <h5>Sizes</h5>
            <label for="medium">Medium</label>
            <input id="medium" name="medium" type="checkbox" checked required>

            <label for="large">Large</label>
            <input id="large" name="large" type="checkbox">

            <label for="medium-price">Medium Price:</label>
            <input name="medium-price" id="medium-price" type="number" maxlength="5" required placeholder="1200">

            <label for="large-price">Large Price:</label>
            <input name="large-price" id="large-price" type="number" maxlength="5" placeholder="1600">

            <label for="menu-item-image">Upload Menu Image:</label>
            <input name="menu-item-image" type="file">

            <input type="submit" name="add-to-menu" value="Add to Menu"></input>
        </form>

        
        <!--Edit menu-->
        <h4>Edit Menu Item</h4>
        
        <form action="../BusinessLogic/UpdateMenuController.php" method="post" id="edit-form">
            
            <select name="menu-for-edit" id="menu-for-edit">
                <?php
                    $results = $db->menuInfo();
                    foreach($results as $row): ?>
                        <option value="<?=$row['id']?>"><?=$row['name'].", ".$row['category'] ?></option>
                <?php endforeach ?>
            </select>
            

            <label for="name">Name:</label>
            <input id="name" name="name" type="text" maxlength="50" required placeholder="Item Name">

            <label for="category">Category:</label>
            <input name="category" type="text" maxlength="35" required placeholder="Category">
            <br><br>

            <label for="medium">Medium</label>
            <input id="medium" name="medium" type="checkbox" checked required>

            <label for="large">Large</label>
            <input id="large" name="large" type="checkbox">

            <label for="medium-price">Medium Price:</label>
            <input name="medium-price" id="medium-price" type="number" required maxlength="5" placeholder="1200">

            <label for="large-price">Large Price:</label>
            <input name="large-price" id="large-price" type="number" maxlength="5" placeholder="1600">

            
            <input type="submit" name="edit-menu" value="Edit Item"></input>
        </form>


        <!--Delete from menu-->
        <h4>Delete Menu Item</h4>
        <form action="../BusinessLogic/UpdateMenuController.php" method="post"id="delete-form">
            <select name="menu-for-del" id="menu-for-del">
                <?php
                    $results = $db->menuInfo();
                    foreach($results as $row): ?>
                        <option value="<?=$row['id']?>"><?=$row['name'].", ".$row['category'] ?></option>
                
                <?php endforeach ?>
            </select>
            <input type="submit" name="del-from-menu" value="Delete Item"></input>
        </form>

        
        <!--Mark as out of stock-->
        <h4>Mark Item Out of Stock</h4>
        <form action="../BusinessLogic/UpdateMenuController.php" method="post"id="out-stock-form">
            <select name="menu-for-out" id="menu-for-out">
                <?php
                    $results = $db->menuInfo();
                    foreach($results as $row): ?>
                        <option value="<?=$row['id']?>"><?=$row['name'].", ".$row['category'] ?></option>
                
                <?php endforeach ?>
            </select>
            <input type="submit" name="out-from-menu" value="Enter"></input>
        </form>
        
        <!--Mark as in stock-->
        <h4>Mark Item In Stock</h4>
        <form action="../BusinessLogic/UpdateMenuController.php" method="post"id="in-stock-form">
            <select name="menu-for-in" id="menu-for-out">
                <?php
                    $results = $db->menuInfo();
                    foreach($results as $row): ?>
                        <option value="<?=$row['id']?>"><?=$row['name'].", ".$row['category'] ?></option>
                
                <?php endforeach ?>
            </select>
            <input type="submit" name="in-from-menu" value="Enter"></input>
        </form>

        <a href="#" class="toplink">
            <button class="linkButton"><img src="../images/toparrow.png">Back to top</button>
        </a>

    </div>

    

</body>
</html>
