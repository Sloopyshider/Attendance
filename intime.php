
<?php

include "sections/session.php";


?>

<?php
if(!isset($_SESSION['user'])){
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
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
            document.getElementById(id).innerHTML=val;


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
date_default_timezone_set('Asia/Singapore');
$timein = date('H:i:s');


if(isset($_SESSION['user'])) {

    $stmt = $conn->prepare("SELECT * FROM timeattend WHERE users_id=:users_id ");
    $stmt->execute(['users_id' => $_SESSION['user']]);

};



echo ' 


<table style="bottom: 20%">
    <tr>
        <th width="150px">
        Date</th>
        <th width="150px">Day of the Week</th>
        <th width="150px">Time in</th>
        <th width="150px">Time out</th>
        <th width="150px">Total</th>

    </tr>
    <tr>
    ';

foreach ($stmt as $row)

// $date = date_create($row['datetd']);


    echo '   
   
        <td>'.$row["datetd"].' </td>
        <td>'.$row["timein"].'</td>
        <td>'.$row["timeout"].'</td>
        <td>'.$row["total"].'</td>
    
        <td></td>
    </tr>
    ';

echo '
    <tr>
        <td> Tuesday </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td> Wednesday </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td> Thursday </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td> Friday </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
';


echo'

<label class="labellates"> No. of Lates: </label>

<label class="labelpresent"> Days Present: </label>


<label class="labelabsent"> No. of Absents: </label>

<label class="labeltimesheet"> Time Sheet </label>
<br>
<br>
<br>
<br>
<br>
<br>
&nbsp;
<label class="clock">
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

<?php
date_default_timezone_set('Asia/Singapore');
$timein = date('H:i:s');

if(isset($_SESSION['user'])) {

    $stmt = $conn->prepare("SELECT * FROM timeattend WHERE users_id=:users_id and datetd =   current_date ");
    $stmt->execute(['users_id' => $_SESSION['user']]);
    $users_id = $stmt->fetch();

};


echo ' 
 
   
 
 
  <form action="insert.php" method="POST"  >

    <br>        
     &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
       &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
     <button class="timein" name="Timein" type="submit" onclick="btn()"> Time In </button>
     <br>
     <br>
     <br>
     <br>
     
        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
       &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp; &nbsp;&nbsp;&nbsp;
           <button class="timeout" name="Timeout" type="submit" onclick="button()"> Time Out  </button>
     
     <input type="hidden" max="100" name="users_id" placeholder="'.$user['id'].'" value="'.$user['id'].'" ><br><br>
  <!--Time In and out Value-->
  
     <input type="hidden" name="timein" placeholder="id" value="'.$timein.'" hidden><br><br>
     <input type="hidden" name="timeout" placeholder="First Name" value="'.$timein.'" hidden><br><br>
       
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