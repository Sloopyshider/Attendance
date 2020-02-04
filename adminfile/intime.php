<?php
include "sections/session2.php";
?>

<?php
if(!isset($_SESSION['admin'])){
    header('location: index.php');
}

date_default_timezone_set('Asia/Manila');
$timein1 = date('H:i:s');

/*Pagination Here*/



$stmt = $conn->prepare("select *from timeattend WHERE users_id = :users_id and datetd =CURRENT_DATE ORDER BY users_id DESC LIMIT 1");
$stmt->execute(['users_id' => $_SESSION['admin']]);


$conn = $pdo->open();

$status1 = "Late";
$status2 = "Present";
$status3 = "Absent";

$stmt1 = $conn->prepare("SELECT * FROM employee WHERE id=:id");
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

    $basetime = strtotime('09:00:00 am');
    $basetime1 = date("H:i:s",$basetime);


    $basetimecreate = date_create($basetime1);

/*ends here*/
/*Create a difference between 9am - time in $intminval = date_interval_format($intmin,'%h%i%s');*/
    $time1 = date_create($timein);
//    $intmin = date_diff($time1,$basetimecreate);
//
//    $ints = $intmin->format("%d");
//
//
//    $ints1 =  strtotime($ints);
//    $ints2 = date('H:i:s',$ints1);
//    $ints3 = date_create($ints2);
    /*Created the difference*/


    $int = date('H:i:s',1580174100);
    $int1 = date_create($int);
    $int2 = date_diff($time1,$int1);

    $int3 = $int2->format("%h");

    $int4 = date_create($int3);

    $time2 = date_create($timeout);
    $interval = date_diff($int1,$time2);

//    $ge = strtotime("9:15:00");
//    var_dump($ge);
//    exit();

    $date = date('M. d, Y', strtotime($date1));
    $dayOfTheWeek = date('l', strtotime($date));

    $savedTimeIn = $timein ? date_create($timein)->format('h:i:s A') : '';
    $savedTimeOut = $timeout ? date_create($timeout)->format('h:i:s A') : '';

    $total = "";

    if ($total < $timein)
    {
        $total =  $interval->format("%h");

    }
    elseif ($total > $timeout){
        $total =  $interval->format("%h");

    }
    else
    {
        "";
    }


    $hello = number_format($total);
    $hello1 = number_format($int3);
    $hello2 = $total - $int3 ;

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
            'total' => $hello2,
            'status' => $status
    ];

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
    <script type="text/javascript" src="/attendance/cssfiles/main.js"></script>
    <link href="/Attendance/cssfiles/main.css" rel="stylesheet" type="text/css">

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


<body>
<hr>

<?php

echo ' 
<table class="table1">
    <tr>
        <th>Date</th>
        <th width="70px">Day of the Week</th>
        <th width="150px">Time in</th>
        <th width="150px">Time out</th>
        <th width="150px">Total Hours</th>
        <th width="150px">Status</th>

    </tr>
    ';

try{

    foreach($attendances as $attendance) {
        echo "<tr'>";

        echo " 
        <td>".$attendance['date']."</td>
        <td>".$attendance['day']."</td>
        <td>".$attendance['timeIn']."</td>
        <td>".$attendance['timeOut']."</td>
        <td>".$attendance['total']." hr/s</td>
        <td>".$attendance['status']."</td>
        
    ";

        echo "</tr> 

";
    }
}
catch(PDOException $e){
    echo "There is some problem in connection: " . $e->getMessage();
}


echo '
</table>
';


echo'

<label class="labellates"> No. of Lates:
';



echo $sqllate;



echo '
 
</label>

<label class="labelpresent"> Days Present: '; echo $sqlpresent; echo '</label>


<label class="labelabsent"> No. of Absents: </label>

<br><br><br><br><br><br>
&nbsp;
<label class="clock     ">
    <span id="hr">00</span>
    <span> : </span>
    <span id="min">00</span>
    <span> : </span>
    <span id="sec">00</span>
</label>
<br>
'
?>


<!--Controller 2-->

<?php
date_default_timezone_set('Asia/Singapore');

    $datetoday = date("d");
$datetoday1 = date("Y-m-d");

$timer = date('H:i:s');


echo ' 
 

   
    <script>    
     function inbtn() {
          var retVal = confirm("Do you want to TIME IN ?");
               if( retVal == true ) {
          
                  return true;
               } else {
                  return false;
               }   
     }
     
      function outbtn() {
          var retVal = confirm("Do you want to TIME OUT ?");
               if( retVal == true ) {
          
                  return true;
               } else {
                  return false;
               }   
     }
    </script>
   
 
  <form action="insert.php" method="POST"  name="form" >

    <br>        
   &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
       &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
          
          ';

$tib = "<button onsubmit=\"return isValidForm()\" class=\"timein\" id=\"timein\" name=\"Timein\" type=\"submit\" onclick=\"return inbtn()\" > Time In </button> 
";


if($date1 == $datetoday1){
    echo 'You Login in Today';
 }
elseif($date1 != null){
    echo $tib;
}
else{
    echo $tib;
}


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


$tob = "<button class=\"timeout\" name=\"Timeout\" type=\"submit\" onclick=\"return outbtn()\"> Time Out </button>";
if($timeout != null and  $datetoday != $date1)
{
    echo "";}
elseif($timein > null){
    echo $tob;
}
 echo '<input type="hidden" max="100" name="users_id" placeholder="'.$admin['id'].'" value="'.$admin['id'].'" ><br><br> </form>  
' ?>
<!--Time in End-->



</body>
<?php
include "sections/footer2.php";
?>
</html>