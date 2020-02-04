<?php

include "sections/session.php";


$timein = $conn->query("SELECT *  FROM timeattend where datetd = current_date  ")->fetch();

$date1 = strtotime('9:00:00 am');
$time1 = date("H:i:s",$date1);


$date3 = strtotime($timein['timein']);
$time3 = date("H:i:s",$date3);

$date2 = strtotime($timein['timeout']);
$time2 = date("H:i:s",$date2);




if ($time1 <= $time2)
{
   $time3 = $time1;
}
else{
    echo "900am";
}

$time100 = date_create($time1);
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
    $total =  $interval->format("%h %i %s hr/s");
}

echo $total;

;

echo "hello";



//$a = "Name1";
//$b = "Name 2";
//$c = "Name 3";
//
//$v1 = 1;
//$v2 = 2;
//$v3 = 3;
//
//if ($b > $a)
//{
//
//    echo $a;
//}
//elseif ($c < $a)
//{
//
//
//
//    return $b;
//}
//else
//{
//
//    echo $c;
//}




// "<button class=\"timeout\" name=\"Timeout\" type=\"submit\" onclick=\"btn()\"> Time Out </button>";
// "<button class=\"timein\" name=\"Timein\" type=\"submit\" onclick=\"btn()\"> Time In </button>";

//Starting time is 9am













/*Date Today - One Data per Day*/
//$hello = date("Y-m-d");
//
//$message = "Time in Today";
//
//
//$message1 = "Success";
//
//
//
//$hello1 = '';
//
//$datetoday = $conn->query("SELECT * FROM `timeattend` WHERE datetd = current_date")->fetch();
//
//
//if ($datetoday['datetd'] == $hello){
//
//    echo "<script type='text/javascript'>alert('$message');</script>";
//}
//
//else{
//    echo $datetoday['datetd'];
//    echo $hello;
//}
//

/*Save to excel
 *
 * include "sections/session.php";


//Create our SQL query.
$sql = "SELECT * FROM timeattend LIMIT 20";

//Prepare our SQL query.
$statement = $conn->prepare($sql);

//Executre our SQL query.
$statement->execute();

//Fetch all of the rows from our MySQL table.
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

//Get the column names.
$columnNames = array();
if(!empty($rows)){
    //We only need to loop through the first row of our result
    //in order to collate the column names.
    $firstRow = $rows[0];
    foreach($firstRow as $colName => $val){
        $columnNames[] = $colName;
    }
}

//Setup the filename that our CSV will have when it is downloaded.
$fileName = 'mysql-export.csv';

//Set the Content-Type and Content-Disposition headers to force the download.
header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="' . $fileName . '"');

//Open up a file pointer
$fp = fopen('php://output', 'w');

//Start off by writing the column names to the file.
fputcsv($fp, $columnNames);

//Then, loop through the rows and write them to the CSV file.
foreach ($rows as $row) {
    fputcsv($fp, $row);
}

fclose($fp);*/



//$a = "Not Late";
//$b = "Late";
//$c = "Absent";
//
//
//$date_1 = "2020-03-12 00:00:00";
//$date_2 = "Wednesday";
//
//$date1 = new DateTime($date_1);
//$date2 = new DateTime($date_2);
//
////$count = date_diff($date2,$date1);
//
//$time = strtotime("09:16 am");
//
//
//
//
//$date_expire = '2014-08-06 00:00:00';
//$date = new DateTime($date_expire);
//$now = new DateTime();
//
//echo $date1->diff($date)->format("%y years, %M month and %d days");
//
//echo $count;

//echo date('M D Y',$time);



?>

