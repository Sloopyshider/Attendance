<?php

include "sections/session.php";
include  "sections/navbar.php";

if (isset($_GET['s_id'])) {
    $users_id = $_GET['s_id'];
    $sql = "SELECT * FROM timeattend WHERE users_id=$users_id ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edmin</title>
    <link type="text/css" href="admin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="admin/css/theme.css" rel="stylesheet">
    <link type="text/css" href="admin/images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>

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



    </script>
</head>
<body>

<!--RIGHT FORMAT WRAPPER Container ROW DOWN SIDE INCLUDE SIDEBAR-->
<div class="wrapper">
    <div class="container">
        <div class="row">
<?php include "sections/sidebar.php"?>

            <div class="span9">
                <div class="content">

                    <div class="module">
                        <div class="module-head">
                            <h3>Forms</h3>
                        </div>
                        <div class="module-body">

                            <div class="title"> <div class="clock">   <span id="hr">00</span>
                                    <span> : </span>
                                    <span id="min">00</span>
                                    <span> : </span>
                                    <span id="sec">00</span>
                                </div> </div>


                            <?php


                            date_default_timezone_set('Asia/Singapore');
                            $timein = date('H:i:s');




                            if(isset($_SESSION['user'])){

                                $stmt = $conn->prepare("SELECT * FROM timeattend WHERE users_id=:users_id and datetd = current_date ");
                                $stmt->execute(['users_id'=>$_SESSION['user']]);
                                $users_id = $stmt->fetch();





                                echo '    <br>       
                            <p style="font-size: 50px" > Today Date is '.$users_id['datetd'].'</p> <br>   
                            <p style="font-size: 50px" > Time in = '.$users_id['timein'].'</p> <br>   
                            <form action="insert.php" method="POST">
                        <input type="submit" name="Timein" value="Time-IN">
                               
                        <input type="hidden" max="100" name="users_id" placeholder="'.$user['id'].'" value="'.$user['id'].'" ><br><br>
                        <input type="hidden" name="timein" placeholder="id" value="'.$timein.'" readonly><br><br>
                        
                        
                        <input type="date" name="datetd" placeholder="Last Name" value="<?php echo $today;?>" readonly><br><br>
                        <input type="number" min="10" max="100" name="total" placeholder="Age" value="<?php echo $total;?>"><br><br>
                        <input type="time" name="timeout" placeholder="First Name" value="<?php echo $timeout;?>"><br><br>
                        

                        

                        </form>                                

                      <p>
                        '.$users_id['timein'].' '.$user['contact'].'
                        Member since '.  $user['address'].'
                      </p>
                    </li>
                    <li class="user-footer">
                      <div class="pull-left">
                        <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                      </div>
                      <div class="pull-right">
                        <a href="sections/logout.php" class="btn btn-default btn-flat">Sign out</a>
                      </div>
                    </li>
                  </ul>
                </li>
              ';
                            }
                            else{
                                echo "
                <li><a href='login.php'>LOGIN</a></li>
                <li><a href='signup.php'>SIGNUP</a></li>
              ";
                            }

                            ?>
                            <br>
                            <br>
                            <div class="title"> <div class="clock">   <span id="hr">00</span>
                                    <span> : </span>
                                    <span id="min">00</span>
                                    <span> : </span>
                                    <span id="sec">00</span>
                                </div> </div>
                            <?php
                            date_default_timezone_set('Asia/Singapore');
                            $timein = date('H:i:s');

                            date_default_timezone_set('Asia/Singapore');
                            $timeout = date('H:i:s');

                            ?>

                            <br>




                            <br />



                            <form class="form-horizontal row-fluid" action="time_add.php" method="POST">
                                <div class="controls">
                                    <input type="label" value="<?php echo $timein; ?>" class="control-label" name="times"  class="span8"  > </input>
                                    <br> <br>
                                    <input type="submit"  name="timeadd"  ONCLICK="window.location.reload();">
                                </div>

                                <br>
                                <br>

                            </form>

                            <form action="insert.php" method="POST">

                                <input type="number" max="100" name="users_id" placeholder="User Id" value="<?php echo $users_id;?>"><br><br>
                                <input type="time" name="timein" placeholder="id" value="<?php echo $timein;?>"><br><br>
                                <input type="time" name="timeout" placeholder="First Name" value="<?php echo $timeout;?>"><br><br>
                                <?php

                                $month = date('m');
                                $day = date('d');
                                $year = date('Y');

                                $today = $year . '-' . $month . '-' . $day;
                                ?>
                                <input type="date" name="datetd" placeholder="Last Name" value="<?php echo $today;?>" readonly><br><br>
                                <input type="number" min="10" max="100" name="total" placeholder="Age" value="<?php echo $total;?>"><br><br>



                                <input type="submit" name="Timein" value="Time-IN">
                                <input type="submit" name="Timeout" value="Time-OUT">
                                <input type="submit" name="Total" value="Total">


                                <br>

                                <input type="submit" name="insert" value="Insert">

                                <input type="submit" name="update" value="Update">
                                <br>
                                <input type="submit" name="delete" value="Delete">
                                <input type="submit" name="search" value="Search">

                            </form>





                </div><!--/.content-->
            </div><!--/.span9-->
</div>
    </div>
</div>

<?php include "sections/footer.php"?>
</body>