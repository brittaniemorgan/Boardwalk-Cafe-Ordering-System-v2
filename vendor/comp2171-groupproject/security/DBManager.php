<link rel="stylesheet" href="index.css">
<?php
/**
*@package Database
*/
class DBManager{

    private $conn;
    private $host;
    private $username;
    private $password;
    private $dbname;
    public static $db; 


    function __construct()
    {
          $this->host = 'localhost';
          $this->username = 'boardwalk_user';
          $this->password = 'password123';
          $this->dbname = 'cafeInfo';

        
        date_default_timezone_set('EST');

        try{
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->dbname,
                $this->username,
                $this->password
            );
            
        }catch(Exception $e){
            die($e->getMessage());
        }
        #add static getDatabase();
        $db = $this;
        
    }

    public static function getDatabase(){
        if (isset($db)){
            return self::$db;
        }
        else{
            return new DBManager(); 
        }
    }

    function getUsers(){
      $stmt = $this->conn->query("SELECT * FROM users");
      return $stmt->fetchAll();
    }

    function getConn(){
        return $this->conn;
    }
    #working
    function menuInfo(){
        #get menu items from the database
        $stmt = $this->conn->query("SELECT * FROM menuItems ORDER BY category");
        $results = $stmt->fetchAll();
        return $results;
    }
    #stmt usually doesnt execute when the vallues we are trying to insert bigger than the value defined in the header insql
    #working
    function userInfo($name){
        

        $stmt = $this->conn->prepare("SELECT * FROM `users` WHERE `name` = :name");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        
        if($stmt->execute()){


            if($stmt->rowCount() > 0 ){
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                #tester - later delete
                foreach($results as $row){
                    $info = $row;
                    // echo $row['name'];
                }
                return $info;
            
            }else{
                return 'user not found';
            }

        }
    }

    function updateUserReward($reward,$userid){
        $stmt = $this->conn->prepare("UPDATE `users` SET `reward points` = :reward WHERE `id` = :id");
        $stmt->bindParam(':reward', $reward, PDO::PARAM_INT);
        $stmt->bindParam(':id', $userid, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    
    #working
    function addUser($name, $password){
        
        $already_here = $this->userInfo($name);
        $hashPass = hash("sha512", $password);

        
        
        if($already_here === 'user not found'){

            $stmt = $this->conn->prepare("INSERT INTO `users` (`name`, `password`) VALUES (:name, :password)");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashPass, PDO::PARAM_STR);

            if($stmt->execute()){
                echo 'work';
            }else{
                echo 'an error occurred';
            }
            

        }else{
            echo 'someone already has this username';
        }
             
    }

    
    function deleteUser($name){
        
        $stmt = $this->conn->prepare("DELETE FROM `users` WHERE name = :name");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);

        if($stmt->execute()){
            echo 'user deleted';
        }else{
            echo 'error, user not delete';
        }
    }

    function cusDetails($cusId){
        
        $stmt = $this->conn->prepare("SELECT * FROM `users` WHERE `id` = :cusId");
        $stmt->bindParam(':cusId', $cusId, PDO::PARAM_INT);

        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);       
                return $result;

            }else{
                return 'couldnt find order';
            }

        }else{
            return 'an error';
        }

       }

    function orderDetails($orderId){
        
        $stmt = $this->conn->prepare("SELECT * FROM `orders` WHERE `id` = :orderId");
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);

        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);       
                return $results;

            }else{
                return 'couldnt find order';
            }

        }else{
            return 'an error';
        }

       }

    
    function orderInfo($orderId){
        
        $stmt = $this->conn->prepare("SELECT * FROM `orders` WHERE `id` = :orderId");
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);

        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($results as $row){
                    $info = $row['items'];
                }
                
                return $info;

            }else{
                return 'couldnt find order';
            }

        }else{
            return 'an error';
        }

        #select last order - might need
        #$stmt = $this->conn->prepare("SELECT id FROM orders ORDER BY :id DESC LIMIT 1");
    }

    function getDateOrders($date,$filter){
        if($filter == 'd'){$stmt = $this->conn->prepare("SELECT * FROM `orders` WHERE `date` = :date");
           }
        elseif($filter == 'm'){$stmt = $this->conn->prepare("SELECT * FROM `orders` WHERE MONTH(`date`) = MONTH(:date) AND YEAR(`date`) = YEAR(:date)");
        }
        elseif($filter == 'y'){$stmt = $this->conn->prepare("SELECT * FROM `orders` WHERE YEAR(`date`) = YEAR(:date)");
        }
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   
    function addOrder($total, $items, $genLocation, $address, $cusId, $payment){
        $deliveryPersonnel = "";
        $date = date('Y-m-d');
        $start_time = date('h:i a');
        if ($genLocation == "UWI"){
            $deliveryPersonnel = "Chad Williams";
        }
        else{
            $deliveryPersonnel = "Jason Campbell";
        }

        $stmt = $this->conn->prepare("INSERT INTO `orders` (`total`, `items`, `date`, `gen_del_location`, `address`, `start_time`, `cusId`, `deliveryPersonnel`, `payment`) VALUES (:total, :items, :date, :genLocation, :address, :start_time, :cusId, :deliveryPersonnel, :payment)");
        $stmt->bindParam(':total', $total, PDO::PARAM_INT);
        $stmt->bindParam(':items', $items, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':genLocation', $genLocation, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':start_time', $start_time, PDO::PARAM_STR);
        $stmt->bindParam(':cusId', $cusId, PDO::PARAM_INT);
        $stmt->bindParam(':deliveryPersonnel', $deliveryPersonnel, PDO::PARAM_STR);
        $stmt->bindParam(':payment', $payment, PDO::PARAM_STR);

        if($stmt->execute()){
            echo     "<h1>Your Order Has Been Placed</h1>
            <p>Thank you for ordering with us, we'll contact you by email with your order details.</p>";
        }else{
            echo '<h1>error, couldnt place order</h1>';
        }

    }

    
    function deleteOrder($orderId){
        $stmt = $this->conn->prepare("DELETE FROM `orders` WHERE `id` = :orderId");
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);

        if($stmt->execute()){
            echo 'order deleted';
        }else{
            echo 'error, order deleted';
        }

    }
    
    function getFood($foodID){
        $stmt = $this->conn->query("SELECT * FROM menuItems WHERE id = $foodID");
        $results = $stmt->fetchAll();
        return $results;
    }}

    ?>