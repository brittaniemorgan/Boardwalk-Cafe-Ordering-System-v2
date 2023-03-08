<html>
    <a href="index.php">
        <button>Back To Menu</button>
    </a>
</html>
<?php
    session_start();
    require "DBManager.php";
    $db = new DBManager();
    $conn = $db -> getConn();
    $_SESSION['user'][2] = [];
    
    
?>
