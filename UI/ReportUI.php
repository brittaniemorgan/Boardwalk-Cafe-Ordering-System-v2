<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager - The Boardwalk Cafe</title>
    <link rel="stylesheet" href="../UI/reportUI.css">

</head>
<body>
    <h1>Report</h1>
    <a href="http://localhost/comp2171-groupproject/UI/ReportUI.php?filter=d">
        <button>View Today's Report</button>
    </a>
    <a href="http://localhost/comp2171-groupproject/UI/ReportUI.php?filter=m">
        <button>View This Month's Report</button>
    </a>
    
    <a href="http://localhost/comp2171-groupproject/UI/ReportUI.php?filter=y">
        <button>View This Year's Report</button>
    </a>

    <div>
    <a href="http://localhost/comp2171-groupproject/UI/UpdateMenu.php">
        <button>Update Menu</button>
    </a>
    </div>
    </body>
</html> 
    <?php
    require_once '../BusinessLogic/Menu.php';
    require '../BusinessLogic/ReportController.php';
    class ReportUI{
        private $filters;
        private $reportController;
        private $title;
        function __construct(){
            $this->filters = ['d', 'm', 'y'];
            $this->reportController = new ReportController(new DBManager());
        }

        function viewReport($filter){
            switch($filter){
                case 'd':
                    $this->title = "Today's Orders";
                    break;
                case 'm':
                    $this->title = "This Month's Orders";
                    break;
                case 'y':
                    $this->title = "This Year's Orders";
                    break;
                }
            }
    }

    if (isset($_GET['filter'])){
        $reportUI = new ReportUI();
        $reportUI->viewReport($_GET['filter']);
    }
    
    /*echo $SESSION['admin'][0];
        if (!isset($SESSION["admin"])){
            //header('Location: index.php');

        }*/
        

        #turn on error reporting
        ini_set('display_errors', 'On');
        error_reporting(E_ALL | E_STRICT);

        #connects to databse 
    ?>

