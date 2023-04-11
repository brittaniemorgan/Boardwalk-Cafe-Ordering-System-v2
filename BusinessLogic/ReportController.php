<link rel="stylesheet" href="reportUI.css">
<?php
require_once '../Database/DBManager.php';

#view average time for order, days earnings 

class ReportController{

    private $db;
    

    function __construct($dbmanager)
    {   
        #creates a connection to the database
        $this->db = $dbmanager;

    }

    function retrieveDB($filter){
             #todays date in the format 03/Jan/2028
       # $date = date('m'); #current month
         $date = date('Y-m-d');
        
       
        #count orders from different locations
        $uwi_count = 0;
        $mona_count = 0;
        $hope_pastures_count = 0;
        $papine_count =0;
        $old_hope_count = 0;
        $jc_count = 0;

        $uwi_earnings = 0;
        $mona_earnings = 0;
        $hope_pastures_earnings = 0;
        $papine_earnings = 0;
        $old_hope_earnings = 0;
        $jc_earnings = 0;

        $totalTime = 0;
        
        #get todays orders
       
        $results = $this->db->getDateOrders($date,$filter);
        #tries to execute statement, return error if the database couldnt be queried
        if(count($results)>=0){
            #$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $orders = count($results);

           
            #count the earnings and amount of order placed at each general delivery location (uwi, mona, papine, hope pastures, old hope road and jam college).
            foreach($results as $row){
                                
                switch($row['gen_del_location']){
                    case 'UWI':
                        $uwi_count += 1;
                        $uwi_earnings += $row['total'];
                        break;
                    case 'Mona':
                        $mona_count += 1;
                        $mona_earnings += $row['total'];
                        break;
                    case 'Hope Pastures':
                        $hope_pastures_count += 1;
                        $hope_pastures_earnings += $row['total'];
                        break;
                    case 'Papine':
                        $papine_count += 1;
                        $papine_earnings += $row['total'];
                        break;
                    case 'Old Hope Road':
                        $old_hope_count += 1;
                        $old_hope_earnings += $row['total'];
                        break;
                    case 'Jamaica College':
                        $jc_count += 1;
                        $jc_earnings += $row['total'];
                        break;
                    default:
                        break;
                }

                
                #find time elapsed in miutes
                $time1 = strtotime($row['start_time']);
                $time2 = strtotime($row['end_time']);
                $difference = abs(($time2 - $time1)/60);
                $totalTime += $difference;

            }

            #finds average time, divides the sum of elapsed time on each order by the numnber of orders
            if($orders>0){ $avg_time = round(abs($totalTime/$orders));}
            else{$avg_time = 0;}
           
            
            #return total orders, average time, earnings and number of orders at each location 
            return ['orders'=>$orders, 'avg_time'=>$avg_time, 'uwi_num'=>$uwi_count, 'mona_num'=>$mona_count, 'hope_past_num'=>$hope_pastures_count, 'papine_num'=>$papine_count, 'old_hope_num'=>$old_hope_count, 'jc_num'=>$jc_count, 'uwi_earn'=>$uwi_earnings, 'mona_earn'=>$mona_earnings, 'hope_past_earn'=>$hope_pastures_earnings, 'papine_earn'=>$papine_earnings, 'old_hope_earn'=>$old_hope_earnings, 'jc_earn'=>$jc_earnings];

            echo 'information retrieved successfully';
        }else{
            echo 'information couldnt be retrieved';
        }
        
    }

    function generateReport($filter){
             $results = $this->retrieveDB($filter);   # generate graphical representation of the data
            ?>
            <h5>There were <?=$results['orders']?> orders placed. The average time it took to complete an order/get it ready for delivery was <?=$results['avg_time']?> minutes.</h5>

            <div id="orderRes">
                <p>Orders placed from UWI - <?=$results['uwi_num']?></p>
                <p>Orders placed from Mona - <?=$results['mona_num']?></p>
                <p>Orders placed from Hope Pastures - <?=$results['hope_past_num']?></p>
                <p>Orders placed from Papine - <?=$results['papine_num']?></p>
                <p>Orders placed from Old Hope Road - <?=$results['old_hope_num']?></p>
                <p>Orders placed from Jamaica College - <?=$results['jc_num']?></p>

            </div> 
            <!--Canvas to place pie chart on-->
            <canvas id="numChart" style="width:100%;max-width:700px"></canvas>

            <div id="earnRes">

            <p>Earnings from UWI - $<?=$results['uwi_earn']?></p>
            <p>Earnings from Mona - $<?=$results['mona_earn']?></p>
            <p>Earnings from Hope Pastures - $<?=$results['hope_past_earn']?></p>
            <p>Earnings from Papine - $<?=$results['papine_earn']?></p>
            <p>Earnings from Old Hope Road - $<?=$results['old_hope_earn']?></p>
            <p>Earnings from Jamaica College - $<?=$results['jc_earn']?></p>

            </div>
            
            <!--Canvas to place bar chart on-->
            <canvas id="earnChart" style="width:100%;max-width:700px"></canvas>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

            <?php echo'
            <!--JS Library to make charts-->
            
            <script>

                new Chart("numChart", {
                    type: "pie",
                    data: {
                        labels: ["UWI", "Mona", "Papine", "Hope Pastures", "Old Hope Road", "Jamaica College"],
                        datasets: [{
                        backgroundColor: ["#A86959", "#F58F76", "#6BD7F6", "#A88938", "#F5CA5D", "#93BEF5"],
                        data: ['.$results["uwi_num"].','.$results["mona_num"].','.$results["papine_num"].','.$results["hope_past_num"].','.$results["old_hope_num"].','.$results["jc_num"].']
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: "This Year Orders Based On Destination"
                        }
                    }
                });

                new Chart("earnChart", {
                    type: "bar",
                    data: {
                        labels: ["UWI", "Mona", "Papine", "Hope Pastures", "Old Hope Road", "Jamaica College"],
                        datasets: [{
                        backgroundColor: ["#A86959", "#F58F76", "#6BD7F6", "#A88938", "#F5CA5D", "#93BEF5"],
                        data: ['.$results["uwi_earn"].','.$results["mona_earn"].','.$results["papine_earn"].','.$results["hope_past_earn"].','.$results["old_hope_earn"].','.$results["jc_earn"].']
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: "This Year Earnings Based On Destination"
                        }
                    }
                });

            </script>';

        } 
    }
    if (isset($_GET['filter'])){
        $reportController = new ReportController(new DBManager);
        $reportController->generateReport($_GET['filter']);
    }
?>
