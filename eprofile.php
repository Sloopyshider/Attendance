<?php
include 'sections/navbar2.php';
include "sections/session.php";

if(isset($_POST['update_profile'])){

    $id = $_POST['id'];
    $username = $_POST['username'];
    $fname = $_POST ['fname'];
    $mid_name = $_POST ['mid_name'];
    $last_name = $_POST ['last_name'];
    $bday = $_POST ['bday'];
    $address = $_POST ['address'];
    $city = $_POST ['city'];
    $pass = $_POST ['pass'];
    $confirmpass = $_POST['confirmpass'];
    $new_pass = $_POST['new_pass'];
    $email_add = $_POST ['email_add'];
    $posit = $_POST ['posit'];
    $numb = $_POST ['numb'];



    $stmt = 'UPDATE `employee` SET 

                    `username`=:username,
                    `email`=:email_add,
                    `password`=:pass,
                    `new_pass`=:new_pass,
                    `confirm_pass`=:confirmpass,
                    `name`=:fname,
                    `midname`=:mid_name,
                    `lastname`=:last_name,
                    `pos`=:posit,
                    `birthdate`=:bday,
                    `address`=:address,
                    `city`=:city,
                    `contact`=:numb 
                    
                    WHERE id =:id';

    $parameters = [
        ':username' => $username,
        ':email_add' => $email_add,
        ':pass' => $pass,
        ':new_pass'=> $new_pass,
        ':confirmpass' => $confirmpass,
        ':fname' => $fname,
        ':mid_name' => $mid_name,
        ':last_name' => $last_name,
        ':posit' => $posit,
        ':bday' => $bday,
        ':address' => $address,
        ':city' => $city,
        ':numb' => $numb,
        ':id' => $id

    ];

    $stmt =  $conn->prepare($stmt);
    $pdoExc =  $stmt->execute($parameters);




    if ($pdoExc){
        echo '<script>alert("Successful")</script>';
    }else{
        echo 'error';
    }

}

// 1. FIRST STEP SELECT USER TO BE EDITED
$sql = "SELECT * FROM employee WHERE id=" . $_SESSION['user'];
$queryUser =  $conn->prepare($sql);
$queryUser->execute();
$user = $queryUser->fetch();


$sqlPositions = "SELECT * FROM pos";
$queryPosition = $conn->prepare($sqlPositions);
$queryPosition->execute();
$positions = $queryPosition->fetchAll();




// 2. SETUP VARIABLE TO UTILIZE ON FORM
$userId = $user['id'];
$userName = $user['username'];
$firstname = $user ['name'];
$mid_name = $user ['midname'];
$last_name = $user ['lastname'];
$bday = $user ['birthdate'];
$address = $user ['address'];
$city = $user ['city'];
$email_add = $user ['email'];
$userPositionId = $user['pos'];
$numb = $user ['contact'];
$pass = $user ['password'];
$new_pass = $user ['new_pass'];
$confirmpass = $user ['confirmpass'];

















?>

    <head>

        <title> Employee Profile </title>
        <link href='cssfiles/main.css' rel='stylesheet' type='text/css'>
        <link href='../css/theme.css' rel='stylesheet' type='text/css'>
        <link href='../css/theme.css' rel='stylesheet' type='text/css'>
    </head>
    <body>

<?php



    echo "
        
<hr>
<label class='userdetails'> User Details </label>
<form action='eprofile.php' method='post'> 

<label
    <label class='personal'> Personal Info </label>
    <table class='table2'>
         <th>
                <input type='hidden' placeholder='id' name='id' id='id' value='$userId'>          
                <input type='text' placeholder='Edit your Username' id='username' readonly name='username'  style='width: 100%' value='$userName'/>
            <br>
            <br>
                <input type='text' placeholder='Put your First Name' id='fname'  readonly name='fname'  style='width: 100%'  value='$firstname'/>
            <br>
            <br>
                <input type='text' placeholder='Put your Middle Name' id='mid_name' readonly name='mid_name'   style='width: 100%' value='$mid_name'/>
            <br>
            <br>
                <input type='text' placeholder='Put your Last Name' id='last_name' readonly name='last_name' style='width: 100%' value='$last_name'/>
            <br>
            <br>  
                <input type='date' placeholder='Select Birthdate' id='bday' readonly name='bday'  style='width: 100%' value='$bday'/>
            <br>
            <br>
                <input type='text' placeholder='Street/Block/Subdv No.' id='address' readonly name='address'   style='width: 100%' value='$address'/>
            <br>
            <br>
                <input type='text' placeholder='City' readonly name='city' id='city'   style='width: 100%' value='$city'/>
       </th>

   
    </table>
    <label class='account'> Account Info </label>
    <table class='table3'>
        <th>
                <input type='password' placeholder='Input your Old Password' readonly name='pass' id='opass' style='width: 100%' value='$pass'/>
            <br> <br>
            <input type='password' placeholder='Input your new Password' readonly name='new_pass' id='new_pass' style='width: 100%' value='$new_pass'/>
             <br> <br>
                <input type='password' placeholder='Type again your new password' readonly name='confirmpass' id='confirmpass' value='$confirmpass' style='width: 100%'/>
        </th>
        
     <label class='compinfo'> Company Info </label>
    <table class='table4'>
        <th>
                <input type='email' placeholder='Put your Email'  readonly name='email_add' id='email_add' style='width: 100%' value='$email_add'/>
            <br>
            <br>";



    $positionDropdown = "<select id='posit' name='posit' style='width: 100%' required disabled>";

    foreach ($positions as $position) {
        $positionId = $position['id'];
        $posName = $position['posname'];
        $selected = ($positionId == $userPositionId) ? 'selected': '';

        $positionDropdown .= "<option value='$positionId' $selected>$posName</option>";
    }
    $positionDropdown .= "</select>";
    echo $positionDropdown;


    echo "
            <br>
            <br>
                <input type='number' placeholder='Please put your number' readonly name='numb' id='numb' style='width: 100%' value='$numb'/>
            <br>
        </th> 
    
    
        <button class='sbmt' name='update_profile' onclick='return activate()' id='editButton' value='1'> EDIT </button>
        
            </table>
</form>";



    echo "
            <script type='text/javascript'>
           
                
                let editable = false;
                
                let originalValues = {
                    username: '$userName',
                    fname: '$firstname',
                    mid_name: '$mid_name',
                    last_name: '$last_name',
                    bday: '$bday',
                    address: '$address',
                    city: '$city',
                    pass: '$pass',
                    email_add: '$email_add',
                    numb: '$numb',
                  
                  
                    
                };
            
        
                
                
                
    
                
                function activate() {
           
                    let textFields = [
                        'username', 'fname', 'mid_name', 'last_name', 'bday', 'address', 'city','confirmpass','new_pass', 'pass', 'email_add', 'numb'
                    ];   
                    if(editable) { 
                        if(!confirm('Are you sure you want to update this data?')) {
                            textFields.forEach(textField => {
                                   document.getElementById(textField).value = originalValues[textField];
                            });
                            return false;
                        }
                        return true;
                        
//                            let x = confirm('Are you sure you want to update this data?');
//                            
//                                if (x === true){    
//                                    editable = true;
//                                }else {
//                                    window.location.reload(true);
//                                    return false;
//                                }                    
                        } else
                            textFields.forEach(textField => {
                                document.getElementById(textField).readOnly = false;
                                });
                            document.getElementById('posit').disabled = false;
                            document.getElementById('editButton').innerHTML = 'Update';
                            editable = true;
                            return false;
                        }
                        
                       
                    </script>
        ";
    ?>




<?php
include 'sections/footer2.php';
?>