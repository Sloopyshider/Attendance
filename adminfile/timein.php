
<?php

include "sections/session2.php";




?>

<?php

if(!isset($_SESSION['admin'])){
    header('location: index.php');
}

date_default_timezone_set('Asia/Manila');
$timein1 = date('H:i:s');

$stmt = $conn->prepare("SELECT * FROM timeattend WHERE users_id=:users_id ORDER BY datetd DESC LIMIT 5");
$stmt->execute(['users_id' => $_SESSION['admin']]);

$conn = $pdo->open();

$status1 = "Late";
$status2 = "Present";
$status3 = "Absent";

$stmt1 = $conn->prepare("SELECT * FROM employee   WHERE id=:id");
$stmt1->execute(['id'=>$_SESSION['admin']]);

$attendances = [];

$date1 = '';
$timeout = '';
$timein = '';


foreach ($stmt as $row) {


    $date1 = $row['datetd'];
    $timein= $row['timein'];
    $timeout = $row['timeout'];

    /*Creating the 9am basetime here*/

    $basetime = strtotime('9:00:00 am');
    $basetime1 = date("H:i:s",$basetime);
    $basetimecreate = date_create($basetime1);

    /*ends here*/

    /*Create a difference between 9am - time in */
    $time1 = date_create($timein);
    $intmin = date_diff($time1,$basetimecreate);
    /*Created the difference*/




    $time2 = date_create($timeout);
    $interval = date_diff($basetimecreate,$time2);



    $date = date('M. d, Y', strtotime($date1));
    $dayOfTheWeek = date('l', strtotime($date));

    $savedTimeIn = $timein ? date_create($timein)->format('h:i:s A') : '';
    $savedTimeOut = $timeout ? date_create($timeout)->format('h:i:s A') : '';

    $total = "";

    if ($total > $timein)
    {
        $total =  $interval->format("%h hr/s");

    }
    elseif ($total < $timeout){
        $total =  $interval->format("%h hrs");

    }
    else
    {
        "";
    }


//    if($savedTimeIn && $savedTimeOut) {
//
//    }


    $late = strtotime('9:15:01 am');
    $sta = strtotime($timein);

    if ($late <= $sta){
        $status = $status1;
    }
    else{
        $status = $status2;
    }


    $attendances[] = [
        'date' => $date,
        'day' => $dayOfTheWeek,
        'timeIn' => $savedTimeIn,
        'timeOut' => $savedTimeOut,
        'total' => $total,
        'status' => $status
    ];

//    $total =


}


$sqlpresent = $conn->query("SELECT COUNT(timein) FROM timeattend where users_id=" .$_SESSION['admin'])->fetchColumn();
$sqllate = $conn->query("SELECT COUNT(timein) FROM timeattend WHERE timein >= '09:15:00' and users_id=" .$_SESSION['admin'] )->fetchColumn();


//echo var_dump($total);
//exit();


?>
<!DOCTYPE html>
<html lang="en">
<style>




</style>
<head>

    <meta charset="UTF-8">

    <title> Elite Attendance Monitoring </title>
    <script type="text/javascript" src="/Attendance/cssfiles/main1.js"></script>

    <link href="/cssfiles/main.css" rel="stylesheet" type="text/css">

    <script>       var d,h,m,s,animate;


        function init(){
            d=new Date();
            h=d.getHours();
            m=d.getMinutes();
            s=d.getSeconds();
            clock();
        };

        function clock(){
            s++;
            if(s==60){
                s=0;
                m++;
                if(m==60){
                    m=0;
                    h++;
                    if(h==24){
                        h=0;
                    }
                }
            }
            $('sec',s);
            $('min',m);
            $('hr',h);
            animate=setTimeout(clock,1000);
        };

        function $(id,val){
            if(val<10){
                val='0'+val;
            }
            document.getElementBxyId(id).innerHTML=val;


        };

        window.onload=init;


        $(document).ready(function(){
            $('#btnsubmit').click(function(){
                $('#btnsubmit').attr('type','submit').val('Add');
            });

        })






    </script>
</head>

<?php
include "sections/adminnav.php";
?>

<body value="1">
<hr>


<?php



//date_default_timezone_set('Asia/Singapore');
//    $timein = date('H:i:s');

//    $row = date_format($date,'l');
//    $date = date_create($row['datetd']);



//if(isset($_SESSION['user'])) {
//
//    $stmt = $conn->prepare("SELECT * FROM timeattend WHERE users_id=:users_id ");
//    $stmt->execute(['users_id' => $_SESSION['user']]);
//
//};



echo ' 


<table class="table1" style="bottom: 20%;   " >
    <tr>
        <th width="150px">
        Date</th>
        <th width="150px">Day of the Week</th>
        <th width="150px">Time in</th>
        <th width="150px">Time out</th>
        <th width="150px">Total</th>
        <th width="150px">Status</th>

    </tr>
    ';

try{

    foreach($attendances as $attendance) {
        echo "<tr>";

        echo "
        <td>".$attendance['date']."</td>
        <td>".$attendance['day']."</td>
        <td>".$attendance['timeIn']."</td>
        <td>".$attendance['timeOut']."</td>
        <td>".$attendance['total']."</td>
        <td>".$attendance['status']."</td>
    ";

        echo "</tr>";
    }

}
catch(PDOException $e){
    echo "There is some problem in connection: " . $e->getMessage();
}



echo '
   
';


echo'

<label class="labellates"> No. of Lates:
';



echo $sqllate;



echo '
 
 </label>

<label class="labelpresent"> Days Present: '; echo $sqlpresent; echo '</label>


<label class="labelabsent"> No. of Absents: </label>

<label class="labeltimesheet"> Time Sheet </label>
<br>
<br>
<br>
<br>
<br>
<br>
&nbsp;
<label class="clock     ">
    <span id="hr">00</span>
    <span> : </span>
    <span id="min">00</span>
    <span> : </span>
    <span id="sec">00</span>
</label>
<br>

'?>
&nbsp;
<!--Time In-->

<!--Controller 2-->

<?php
date_default_timezone_set('Asia/Singapore');

$datetoday = date("d");
$datetoday1 = date("Y-m-d");

$timer = date('H:i:s');


echo ' 
 
   
 
 
  <form action="insert.php" method="POST"  >

    <br>        
   &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
       &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
          
          ';




//elseif ($date1 == null)
//{
//    echo " <button class=\"timein\" name=\"Timein\" type=\"submit\" onclick=\"btn()\"> Time In </button>
//   ";
//
//}

echo '  
          
     <br>
     <br>
     <br>
     <br>
          <br>

     
        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
       &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp; &nbsp;&nbsp;
          
          
          ';






echo '  
          
           
     
     <input type="hidden" max="100" name="users_id" placeholder="'.$admin['id'].'" value="'.$admin['id'].'" ><br><br>
  <!--Time In and out Value-->
  
     <input type="hidden" name="timein" placeholder="id" hidden><br><br>
     <input type="hidden" name="timeout" placeholder="First Name"  hidden><br><br>
       
     <input type="hidden" name="datetd" placeholder="Last Name" value="<?php echo $today;?>" hidden><br><br>
     <input type="hidden" min="10" max="100" name="total" placeholder="Age" value="<?php echo $total;?>" hidden><br><br>
     
                                              
    
  
  </form>  
'
?>
<!--Time in End-->



</body>
<?php
include "sections/footer2.php";
?>
</html>
