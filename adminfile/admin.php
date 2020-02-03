<?php

include "adminfile/session2.php";
include "sections/adminnav.php";

echo "";


if (isset($_SESSION['admin'])) {
    echo ' 
      <label class="employeename">
 

        <br>    
                 <label style="margin - left: 20px">Hello:</label> &nbsp;
                ' . $admin['name'] . '
                ' . $admin['midname'] . '
                ' . $admin['lastname'] . '
        <br>
    ';
}

?>