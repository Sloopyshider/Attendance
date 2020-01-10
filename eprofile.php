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
         
                         ';
        }


        ?>

    </div>
</body>

