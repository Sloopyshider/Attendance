<?php

include "sections/session.php";




$dsn = 'mysql:host=localhost;dbname=attendance2';
$username = 'root';
$password = '';

try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $ex) {

    echo 'Not Connected '.$ex->getMessage();

}

$users_id = '';
$timein = '';
$timeout = '';
$date = '';
$total = '';

function getPosts()
{
    $posts = array();


    $posts[0] = $_POST['users_id'];
    $posts[1] = $_POST['timein'];
    $posts[2] = $_POST['timeout'];
    $posts[3] = $_POST['datetd'];
    $posts[4] = $_POST['total'];

    return $posts;
}

//Search And Display Data

if(isset($_POST['search']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        echo 'Enter The User Id To Search';
    }  else {

        $searchStmt = $con->prepare('SELECT * FROM timeattend WHERE users_id = :users_id');
        $searchStmt->execute(array(
            ':users_id'=> $data[0]
        ));

        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($users_id))
            {
                echo 'No Data For This Id';
            }

            $users_id = $user[0];
            $timein = $user[1];
            $timeout = $user[2];
            $datetd = $user[3];
            $total   = $user[4];
        }

    }
}

// Insert Data

if(isset($_['insert']))
{
    $data = getPosts();
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]) | empty($data[4]))
    {
        echo 'Enter The User Data To Insert';
    }  else {

        $insertStmt = $con->prepare('INSERT INTO timeattend(users_id,timein,timeout,datetd,total) VALUES(:users_id,:timein,:timeout,:datetd,:total)');
        $insertStmt->execute(array(
            ':users_id'=> $data[0],
            ':timein'=> $data[1],
            ':timeout'=> $data[2],
            ':datetd'  => $data[3],
            ':total'  => $data[4]
        ));

        if($insertStmt)
        {
            echo 'Data Inserted';
        }

    }
}

if(isset($_POST['Timein']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        echo 'Enter The User Data To Insert';
    }  else {

        $insertStmt = $con->prepare('INSERT INTO timeattend(users_id,timein,datetd) VALUES(:users_id,current_time ,current_date)');
        $insertStmt->execute(array(
            ':users_id'=> $data[0],

        ));

        if($insertStmt)
        {


            echo

            header ("location:intime.php");
        }

    }
}





if(isset($_POST['Timeout']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        echo 'Enter The User Data To Insert';
    }  else {

        $insertStmt = $con->prepare('UPDATE timeattend SET  timeout = current_time where datetd = current_date and users_id = :users_id and timeout
 is null');
        $insertStmt->execute(array(
            ':users_id'=> $data[0],



        ));

        if($insertStmt)
        {
            header ("location:intime.php");
        }

    }
}



//Update Data

if(isset($_POST['update']))
{
    $data = getPosts();
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]))
    {
        echo 'Enter The User Data To Update';
    }  else {

        $updateStmt = $con->prepare('UPDATE users SET fname = :fname, lname = :lname, age = :age WHERE id = :id');
        $updateStmt->execute(array(
            ':id'=> $data[0],
            ':fname'=> $data[1],
            ':lname'=> $data[2],
            ':age'  => $data[3],
        ));

        if($updateStmt)
        {
            echo 'Data Updated';
        }

    }
}

// Delete Data

if(isset($_POST['delete']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        echo 'Enter The User ID To Delete';
    }  else {

        $deleteStmt = $con->prepare('DELETE FROM users WHERE id = :id');
        $deleteStmt->execute(array(
            ':id'=> $data[0]
        ));

        if($deleteStmt)
        {
            echo 'User Deleted';
        }

    }
}

?>