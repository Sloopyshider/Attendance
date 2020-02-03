<?php
include "sections/connect.php";
session_start();

if(isset($_SESSION['admin'])){
    header('location: adminfile/admin.php');
}

if(isset($_SESSION['user'])){
    $conn = $pdo->open();

    try{
        $stmt = $conn->prepare("SELECT * FROM employee   WHERE id=:id");
        $stmt->execute(['id'=>$_SESSION['user']]);
        $user = $stmt->fetch();

        $stmt1 = $conn->prepare("SELECT pos.posname from pos INNER join employee where employee.pos = pos.id and employee.id =:id ");
        $stmt1->execute(['id'=>$_SESSION['user']]);
        $user1 = $stmt1->fetch();

        $stmt2 = $conn->prepare("SELECT * FROM timeattend WHERE users_id = :users_id ");
        $stmt2->execute([':users_id'=>$_SESSION['user']]);
        $user2 = $stmt2->fetch();


    }
    catch(PDOException $e){
        echo "There is some problem in connection: " . $e->getMessage();
    }

    $pdo->close();
}
?>