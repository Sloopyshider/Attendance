<?php
session_start();
session_destroy();

header('location: /Attendance/index.php');
?>