<?php
    require "DBManager.php";
    require "Customer.php";

    class Login{
        private $stmt;
        private $db;
        private $users;
        
        function __construct(){        
            $this->db = DBManager::getDatabase();
            $this->users = $this->db->getUsers();
        }

        function getLogInInfo(){
            return $this->users;
        }

        function checkPassword($username, $password){
            foreach($this->users as $user){
                $hashPass = hash("sha512", $password);
                if (hash_equals($user['password'], $hashPass) && $username==$user["name"]){                
                    return new Customer($user["name"], $user["id"], $user["phoneNum"],$user["reward points"]);
                }
            }
            return false;
        }

        function verifyAdmin($username, $password){
            $adminStmt = $this->db->getConn()->query("SELECT * FROM adminusers");
            $adminLog = $adminStmt->fetchAll();
            foreach($adminLog as $user){
                $hashPass = hash("sha512", $password);       
                if (hash_equals($user['password'], $hashPass) && $username==$user["name"]){                
                    $_SESSION['admin'] = [$user["id"], $user["name"], $user["role"]];
                    
                    switch($_SESSION['admin'][2]){
                    case 'manager':
                        header('Location: managerPage.php'); 
                        break;
                    case 'server':
                        header('Location: ManageOrdersUI.php'); 
                        break;
                    case 'UWI Delivery':
                        header('Location: ManageDeliveriesUI.php'); 
                        break;
                    case 'General Delivery':
                        header('Location: ManageDeliveriesUI.php'); 
                        break;
                    case 'chef': 
                        header('Location: ManageOrderssUI.php');
                        break;
                    }            
                }
            }
            return false;
        }
    

        function registerNewUser($name, $password){
            echo "hello";
            $hashPass = hash("sha512", $password);
            $this->db->addUser($name, $password);
            return $this->checkPassword($name, $hashPass);
        }
    }
?>