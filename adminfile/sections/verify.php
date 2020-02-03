<?php
include 'sections/session.php';
$conn = $pdo->open();

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password123 = $_POST['password'];


    try{

        $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM employee WHERE username = :username");
        $stmt->execute(['username'=>$username]);
        $row = $stmt->fetch();
        if($row['numrows'] > 0){

            if(password_verify($password123, $row['password'] )){
                if($row['pos'] <= 1){
                    $_SESSION['admin'] = $row['id'];
                }
                else{
                    $_SESSION['user'] = $row['id'];
                }
            }
            else{
                $_SESSION['error'] = 'Incorrect Password';
            }

        }
        else{
            $_SESSION['error'] = 'Email not found';
        }
    }
    catch(PDOException $e){
        echo "There is some problem in connection: " . $e->getMessage();
    }

}
else{
    $_SESSION['error'] = 'Input login credentials first';
}

$pdo->close();

header('location: index.php');

?>