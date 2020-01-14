<?php

include "sections/session.php";

?>

<head>

    <title> Employee Profile </title>
    <link href="cssfiles/main.css" rel="stylesheet" type="text/css">
    <link href="../css/theme.css" rel="stylesheet" type="text/css">
    <link href="../css/theme.css" rel="stylesheet" type="text/css">
</head>
<body>


    <div class="head1">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <img class="img1" src="sections/companylogogreen.jpg" alt="comp">
        <img class="img2" src="sections/profile.jpg" alt="avat">
        <?php
        if(isset($_SESSION['user'])){
            echo '
            
 <label class="employeename">
        <br>    Hello: &nbsp; '.$user['name'].'
        <br>
        Intern:    &nbsp      '.$user['pos'].'
        <br>
        Number:      &nbsp   '.$user['contact'].'
        <br>
    
        <a button class="btn" href="sections/logout.php"> Log out</a>
					
    </label>
    <br>
    <br>
    <br>

                         ';
        }


        echo '
<div>
    <label for="ename" style="margin-left: 27%"><b>Name</b></label>
    <input type="text" placeholder="Enter Full Name" name="ename" required>
    
    <label for="epass" style="margin-left: 60px"><b>Password</b></label>
    <input type="password" placeholder="Please Provide A Password" name="epass" required/>
    <br>
    <br>
    <label for="epost" style="margin-left: 26%"><b>Position</b></label>
    <input type="text" placeholder="Enter Position" name="epost" required>
    
    <label for="confirm"><b>Confirm Password</b></label>
    <input type="password" placeholder="Confirm Your Password" name="confirm" required/>
    <br>
    <br>
    <label for="idnum" style="margin-left: 26.5%"><b>ID No.</b></label>
    <input type="number" placeholder="Enter ID Number" name="idnum" required>
    
    <label for="eadd" style="margin-left: 75px"><b>Address</b></label>
    <input type="text" placeholder="Input your address" name="eadd" required/>
    <br>
    <br>
    <label for="bday" style="margin-left: 25.5%"><b>Birthday</b></label>
    <input type="date" placeholder="Select Your Birthdate" name="bday" required/>
    
    <label for="viber" style="margin-left: 95px"><b>Viber</b></label>
    <input type="tel" placeholder="Please Put your Viber Number" name="viber" required/>
    <br>
    <br>
    <input type="button" name="update"  value="Update" class="sbmt"/>
 </div>   
    
    
        '


        ?>

    </div>
</body>


<?php
include include "sections/footer2.php";
?>