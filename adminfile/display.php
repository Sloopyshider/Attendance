
<?php

include "sections/session2.php";

?>

<?php

if(!isset($_SESSION['admin'])){
    header('location: index.php');
}

date_default_timezone_set('Asia/Manila');
// <editor-fold desc="PAGINATION" default="collapsed">

$limit = 7;

$page = isset($_GET['page']) ? $_GET['page']: 0;
$offset = $page * $limit;
$queryTotalCount = $conn->prepare("SELECT COUNT(*) as totalCount FROM timeattend ");
$queryTotalCount->execute(['users_id' => $_SESSION['admin']]);
$totalCount = $queryTotalCount->fetch()['totalCount'];


// </editor-fold>

$stmt = $conn->prepare("SELECT * FROM employee LEFT OUTER JOIN timeattend ON employee.id=timeattend.users_id ORDER BY timeattend.datetd DESC LIMIT $offset, $limit");
$stmt->execute();
$stmt = $stmt->fetchAll();

$conn = $pdo->open();

$status1 = "Late";
$status2 = "Present";
$status3 = "Absent";

$stmt1 = $conn->prepare("SELECT * FROM employee WHERE id=:id");
$stmt1->execute(['id'=>$_SESSION['admin']]);

//$stmt2 = $conn->prepare("SELECT * FROM timeattend");
//$stmt2->execute();
//$admin1 =  $stmt2->fetchAll();
//
//var_dump($admin1);
//exit();

$attendances = [];
$date1 = '';
$timeout = '';
$timein = '';



foreach ($stmt as $row) {
    $name = $row['lastname'];
    $name1 = $row['name'];
    $date1 = $row['datetd'];
    $timein= $row['timein'];
    $timeout = $row['timeout'];

    $fullname = $name .$name1  ;

    $date1 = strtotime('9:00:00 am');
    $time1 = date("H:i:s",$date1);


    $date3 = strtotime($row['timein']);
    $time3 = date("H:i:s",$date3);

    $date2 = strtotime($row['timeout']);
    $time2 = date("H:i:s",$date2);




    if ($time3 > $time1)
    {
        $time3 = $time1;
    }
    else{
        echo "";
    };

    if($time3 > $time1)
    {
        $time3 = $time3;
    }else{
        echo "";
    };

    var_dump($time3);
    exit();

    $time100 = date_create($time3);
    $time200 = date_create($time2);

    $interval = date_diff($time200, $time100);

//echo "\n \n $time1";
//
//echo "\n \n $time2 ";



    $total = "";

    if ($total = 0)
    {
        $total = "";
    }
    else{
        $total =  $interval->format("%h hr/s");
    }



//    /*Creating the 9am basetime here*/
//    $basetime = strtotime('9:00:00 am');
//    $basetime1 = date("H:i:s",$basetime);
//    $basetimecreate = date_create($basetime1);
//    /*ends here*/
//    /*Create a difference between 9am - time in */
//    $time1 = date_create($timein);
//    $intmin = date_diff($time1,$basetimecreate);
//    /*Created the difference*/
//    $time2 = date_create($timeout);
//    $interval = date_diff($basetimecreate,$time2);
//    $interval1 = date_diff($time2,$time1);
//
//   $total = "";
//    if ($timeout > $basetime)
//    {
//        $total = $basetime;
//
//    }
//    elseif ($timeout != null) {
//        $total =  $interval1->format("%h hrs");
//
//    }else{
//        echo "";
//    };


    $date = date('M. d, Y', strtotime($date1));
    $dayOfTheWeek = date('l', strtotime($date));
    $savedTimeIn = $timein ? date_create($timein)->format('h:i:s A') : '';
    $savedTimeOut = $timeout ? date_create($timeout)->format('h:i:s A') : '';



    $late = strtotime('9:15:01 am');
    $sta = strtotime($timein);

    if ($late <= $sta){
        $status = $status1;
    }
    else{
        $status = $status2;
    }
    $attendances[] = [
        'lastname' => $fullname,
        'date' => $date,
        'day' => $dayOfTheWeek,
        'timeIn' => $savedTimeIn,
        'timeOut' => $savedTimeOut,
        'total' => $total,
        'status' => $status
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<style>


    .tbl-qa{width: 100%;font-size:0.9em;background-color: #f5f5f5;}
    .tbl-qa th.table-header {padding: 5px;text-align: left;padding:10px;}
    .tbl-qa .table-row td {padding:10px;background-color: #FDFDFD;vertical-align:top;}



</style>

<head>
    <meta charset="UTF-8">

    <title> Elite Attendance Monitoring </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>



<body>
<?php
include "sections/adminnav.php";
?>
<br>
<hr>
<br>
 <h1 class="rounded-pill" style="background: #33c58e"> <center> Overall Employee Attendance</center></h1>
<br>

<?php
echo '


<table class="table table-hover table-bordered table-striped" style="background: #63fd88">
    <tr class="thead-dark">
        <th style="width: 150px;">Name</th>
        <th style="width: 150px;">Date</th>
        <th style="width: 150px; height: 40px">Day of the Week</th>
        <th style="width: 150px;">Time in</th>
        <th style="width: 150px;">Time out</th>
        <th style="width: 150px;">Total</th>
        <th style="width: 150px;">Status</th>

    </tr>
    ';


try{

    foreach($attendances as $attendance) {
        echo "<tr class='table-borderless '>";

        echo " 
        <td>".$attendance['lastname']."</td>
        <td>".$attendance['date']."</td>
        <td>".$attendance['day']."</td>
        <td>".$attendance['timeIn']."</td>
        <td>".$attendance['timeOut']."</td>
        <td>".$attendance['total']."</td>
        <td>".$attendance['status']."</td>
        ";

        echo "</tr> ";
        ;

    }

} catch(PDOException $e){
    echo "There is some problem in connection: " . $e->getMessage();
}





?>
</tr>
</table>

<center>
<?php

//
//for($initialPage = 0; $initialPage * $limit < $totalCount; $initialPage++) {
//    $displayPage = $initialPage + 1;
//    echo "   &nbsp;
//    <a href='record.php?page=$initialPage' style='margin-left: 10px'> $displayPage</a>
//   ";}

for ($initialPage = 0; $initialPage * $limit < $totalCount; $initialPage++)
{   $displayPage = $initialPage + 1;
    if($initialPage == $page){
        echo " 
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='display.php?page=$initialPage' style='background: cadetblue' class='btn btn-primary stretched-link'>$displayPage </a> 

";
    }
    else{
        echo " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href='display.php?page=$initialPage' class='btn btn-primary stretched-link'> $displayPage </a> " ;
    }
}

?>
</center>
<center>
    <br>
<button class="btn btn-warning" onclick="window.location.href = 'csv.php';";> Save CSV</button>
</center>
</body>
<br>


</html>



