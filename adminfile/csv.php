<?php

include "sections/session2.php";


//Create our SQL query.
$sql = "SELECT * FROM employee LEFT OUTER JOIN timeattend ON employee.id=timeattend.users_id ORDER BY employee.id ";

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

fclose($fp);
?>