


<head>
    <meta charset="UTF-8">
    <link href="cssfiles/main.css" rel="stylesheet" type="text/css">
</head>

<body>



<div class="head1">
    <meta name="viewport" content="width=device-width, initial-scale=0, user-scalable=no">
    <img class="img1" src="sections/companylogogreen.jpg" alt="comp">
    <img src="avatar1.jpg" width="80px" height="80px" class="avatar">


    <?php
    if(isset($_SESSION['user'])){
        echo '
            
 <label class="employeename">
 

        <br>    
                 Hello: &nbsp;
                '.$user['name'].' 
                '.$user['midname'].'
                '.$user['lastname'].'
        <br>
        
            Number:      
            &nbsp   
           '.$user['contact'].'

        ';
    }

    echo'
        <br>
        Position:    &nbsp      
        '.$user1['posname'].'
        <br>
        ' ?>


    <div class="dropdown">
    <img src="down2.jpg" width="22px" height="18px" onclick="myFunction()" class="dropbtn">
    <div id="myDropdown" class="dropdown-content">
    <a href="intime.php">Attendance</a>
    <a href="timein.php ">Record</a>
    <a href="eprofile.php">Employee Profile</a>
    <a href="sections/logout.php">Log out</a>



  </div>
</div>


<script>

    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            let dropdowns = document.getElementsByClassName("dropdown-content");
            let i;
            for (i = 0; i < dropdowns.length; i++) {
                let openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>




</div>
</body>
