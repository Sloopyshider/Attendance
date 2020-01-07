<?php
include "sections/connect.php";
session_start();

if(isset($_SESSION['admin'])){
    header('location: admin/index.html');
}

if(isset($_SESSION['user'])){
    $conn = $pdo->open();

    try{
        $stmt = $conn->prepare("SELECT * FROM employee WHERE id=:id");
        $stmt->execute(['id'=>$_SESSION['user']]);
        $user = $stmt->fetch();

//        $stmt = $conn->prepare("select p.posname, e.name from employee e
//                                            LEFT JOIN position p on p.pos_id = e.pos where id = :id");
//        $stmt->execute(['id'=>$_SESSION['user']]);
//        $user = $stmt->fetch();
//
//        var_dump($user);
//        exit();

    }
    catch(PDOException $e){
        echo "There is some problem in connection: " . $e->getMessage();
    }

    $pdo->close();
}
?>