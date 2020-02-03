
<?php

include "sections/session.php";

?>

<?php

if(!isset($_SESSION['user'])){
    header('location: index.php');
}

date_default_timezone_set('Asia/Manila');
$timein1 = date('H:i:s');

// <editor-fold desc="PAGINATION" default="collapsed">

$limit = 3;

$page = isset($_GET['page']) ? $_GET['page']: 0;
$offset = $page * $limit;
$queryTotalCount = $conn->prepare("SELECT COUNT(*) as totalCount FROM timeattend WHERE users_id=:users_id");
$queryTotalCount->execute(['users_id' => $_SESSION['user']]);

$totalCount = $queryTotalCount->fetch()['totalCount'];


// </editor-fold>

$stmt = $conn->prepare("SELECT * FROM timeattend WHERE users_id=:users_id ORDER BY datetd DESC LIMIT $offset, $limit");
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

</head>

<?php
include "sections/navbar2.php";
?>

<body>
<hr>
<br>

<?php
echo '


<table class="tbl-qa">
    <tr>
        <th style="width: 150px;">
            Date</th>
        <th style="width: 150px; height: 40px">Day of the Week</th>
        <th style="width: 150px;">Time in</th>
        <th style="width: 150px;">Time out</th>
        <th style="width: 150px;">Total</th>
        <th style="width: 150px;">Status</th>

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

        echo "</tr> ";
        ;

    }

} catch(PDOException $e){
    echo "There is some problem in connection: " . $e->getMessage();
}





?>
</tr>
</table>
<br>

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
        echo "<alink href='record.php?page=$initialPage' style='margin-left: 10px; '><font size='10px'>$displayPage</font>  </alink>";
    }
    else{
        echo "<a href='record.php?page=$initialPage' style='margin-left: 10px; background: red'> <font size='5px'> $displayPage </font></a> ";
    }
}

?>

</body>

<?php
include "sections/footer2.php";
?>
</html>



