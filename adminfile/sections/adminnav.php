
<head>
    <meta charset="UTF-8">
    <link href="/Attendance/cssfiles/main.css" rel="stylesheet" type="text/css">
</head>

<body>



<div class="head1">
    <meta name="viewport" content="width=device-width, initial-scale=0, user-scalable=no">
    <img class="img1" src="/Attendance/sections/companylogogreen.jpg" alt="comp">
    <img src="/Attendance/avatar1.jpg" width="80px" height="80px" style="margin-left: 48%">


    <?php
    if(isset($_SESSION['admin'])){
        echo '
            
 <label class="employeename">
 

        <br>    
                 <label style="margin-left: 20px">Hello:</label> &nbsp;
                '.$admin['name'].' 
                '.$admin['midname'].'
                '.$admin['lastname'].'
        <br>
        
            Number:      
            &nbsp   
           '.$admin['contact'].'

        ';
    }

    echo'
    
        <br>
        ' ?>


    <div class="dropdown">
        <img src="/Attendance/down2.jpg" width="25px" height="20px" onclick="myFunction()" class="dropbtn">
        <div id="myDropdown" class="dropdown-content">
            <a href="intime.php">Attendance</a>
            <a href="timein.php ">Record</a>
            <a href="eprofile.php">Employee Profile</a>
            <a href="">View All</a>
            <a href="/Attendance/sections/logout.php">Log Out</a>





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
