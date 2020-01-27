
<?php

include "sections/session.php";




?>

<?php

if(!isset($_SESSION['user'])){
    header('location: index.php');
}

date_default_timezone_set('Asia/Manila');
$timein1 = date('H:i:s');

$stmt = $conn->prepare("SELECT * FROM timeattend WHERE users_id=:users_id ");
$stmt->execute(['users_id' => $_SESSION['user']]);

$conn = $pdo->open();

$status1 = "Late";
$status2 = "Present";
$status3 = "Absent";

$stmt1 = $conn->prepare("SELECT * FROM employee   WHERE id=:id");
$stmt1->execute(['id'=>$_SESSION['user']]);

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


$sqlpresent = $conn->query("SELECT COUNT(timein) FROM timeattend where users_id=" .$_SESSION['user'])->fetchColumn();
$sqllate = $conn->query("SELECT COUNT(timein) FROM timeattend WHERE timein >= '09:15:00' and users_id=" .$_SESSION['user'] )->fetchColumn();


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
    <script type="text/javascript" src="cssfiles/main1.js"></script>

    <link href="cssfiles/main.css" rel="stylesheet" type="text/css">

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
include "sections/navbar2.php";
?>

<body>
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


<table style="bottom: 20%">
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

//$conn = $pdo->open();
//
//
//
//$status1 = "Late";
//$status2 = "Present";
//$status3 = "Absent";


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

//    foreach($stmt as $row){
//        $stmt1 = $conn->prepare("SELECT * FROM employee   WHERE id=:id");
//        $stmt1->execute(['id'=>$_SESSION['user']]);
//        $savedTimeIn = date_create($row['timein']);
//        $savedTimeOut = date_create($row['timeout']);
//        $interval = date_diff($savedTimeIn, $savedTimeOut);
//
//
//        foreach($stmt1 as $row2){
//            $total = $interval->format('%H');
//
//            $sta = strtotime($row['timein']);
//            $sta1 = strtotime($row['timeout']);
//
//            $late = strtotime('9:15:01am');
//            $sta11 = strtotime("10am");
//
//            if ($late <= $sta){
//                $status = $status1;
//            }
//            else{
//                 $status = $status2;
//            }
//
////            $row['timeout'] = ($sta < $sta1 ? "$sta11" : '');
//
//            //
////            if($row['timein'] <= $late)
////            {
////                    $status = $status1;
////            }
////            elseif ($row['timein'] <= $present)
////            {
////                $row['timein'] = "Present";
////            }
////            elseif($row['timein'] = $absent)
////            {
////                $row['timein'] = "Absent";
////            }
//
//
////            if($late < $row['timein'])
////            {
////                $late = "Not Late";
////            }
////            else{
////                $late = "Shit";
////            }
//
//
//
////            if ($null < $try1){
////                    $null = "Late";
////            }
////            else{
////                $row['timein'] = "hello1";
////            }
////
//
//
////            if ($null > 1)
////            {
////                $row['timein'] = $null;
////            }
////            else
////            {
////                $total;
////            }
////            $datets = date_create($row,['datetd']);
////            $datets = date_format($datets, 'l');
//
//        }
//        echo "
//
//	        										<td>".date('M. d, Y', strtotime($row['datetd']))."</td>
//	        										<td>".date('l', strtotime($row['datetd']))."</td>
//	        										<td >$savedTimeIn</td>
//	        										<td>$savedTimeOut</td>
//	        										<td> $total hrs</td>
//	        									    <td>$status $sta</td>
//	        										</tr>
//	        								";
//    }

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


$tib = "<button class=\"timein\" name=\"Timein\" type=\"submit\" onclick=\"btn()\"> Time In </button>";
if($date1 == $datetoday1){
    echo 'You Login in Today';
 }
elseif($date1 != null){
    echo $tib;
}
else{
    echo $tib;
}


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


$tob = "<button class=\"timeout\" name=\"Timeout\" type=\"submit\" onclick=\"btn()\"> Time Out </button>";
if($timeout != null and  $datetoday != $date1)
{
    echo "";}
elseif($timein > null){
    echo $tob;
}




          echo '  
          
           
     
     <input type="hidden" max="100" name="users_id" placeholder="'.$user['id'].'" value="'.$user['id'].'" ><br><br>
  <!--Time In and out Value-->
  
     <input type="hidden" name="timein" placeholder="id" hidden><br><br>
     <input type="hidden" name="timeout" placeholder="First Name"  hidden><br><br>
       
     <input type="hidden" name="datetd" placeholder="Last Name" value="<?php echo $today;?>" hidden><br><br>
     <input type="hidden" min="10" max="100" name="total" placeholder="Age" value="<?php echo $total;?>" hidden><br><br>
     
                                              
    
  
  </form>  
'

?>
<!--Time in End-->


<div class="vl">
</div>
</body>
<?php
include "sections/footer2.php";
?>
</html>