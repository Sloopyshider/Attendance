<?php
include "sections/session.php";
include 'sections/navbar2.php';




if(isset($_POST['update_profile'])){

    $id = $_POST['id'];
    $username = $_POST['username'];
    $fname = $_POST ['fname'];
    $mid_name = $_POST ['mid_name'];
    $last_name = $_POST ['last_name'];
    $bday = $_POST ['bday'];
    $address = $_POST ['address'];
    $email_add = $_POST ['email_add'];
    $posit = $_POST ['posit'];
    $numb = $_POST ['numb'];
    $numb2 = $_POST ['numb2'];
    $pass = $_POST ['pass'];
    $con_pass = $_POST ['con_pass'];


    $proceed = true;

    if($pass || $con_pass) {
        if($pass != $con_pass) {
            echo '<script>alert("Password not match")</script>';
            $proceed = false;
            header('e.profile.php');
        } else {
            $pass = password_hash($pass, PASSWORD_DEFAULT);
        }
    }

    if($proceed) {
        $stmt = 'UPDATE `employee` SET 

                    `username`=:username,
                    `email`=:email_add,
                    `password`=:pass,
                    `name`=:fname,
                    `midname`=:mid_name,
                    `lastname`=:last_name,
                    `pos`=:posit,
                    `birthdate`=:bday,
                    `address`=:address,
                    `contact`=:numb,
                    `sub_contact`=:numb2 
                    
                    WHERE id =:id';

        $parameters = [
            ':username' => $username,
            ':email_add' => $email_add,
            ':pass' => $pass,
            ':fname' => $fname,
            ':mid_name' => $mid_name,
            ':last_name' => $last_name,
            ':posit' => $posit,
            ':bday' => $bday,
            ':address' => $address,
            ':numb' => $numb,
            ':id' => $id,
            ':numb2' => $numb2
        ];

        $stmt =  $conn->prepare($stmt);
        $pdoExc =  $stmt->execute($parameters);
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
$email_add = $user ['email'];
$userPositionId = $user['pos'];
$numb = $user ['contact'];
$pass = $user ['password'];
$con_pass = $user ['password'];
$numb2 = $user ['sub_contact'];


?>

    <head>
        <title> Employee Profile </title>
        <link href='cssfiles/main.css' rel='stylesheet' type='text/css'>

    </head>
<body>

<?php

echo"


        
<hr>
<br>

<form action='eprofile.php' method='post'>
<td>
<div style='padding-top: 50px'>
    <input type='hidden' placeholder='id' name='id' id='id' value='$userId'> 
   
    <label style='padding-left: 362px'>Username:</label><input type='text' placeholder='Edit your Username' id='username' readonly name='username' pattern='[a-z]{2,}'  style='width: 20%' value='$userName'/>
     <label style='margin-left: 165px'></label>E-mail:<input type='email' placeholder='Put your Email'  readonly name='email_add' id='email_add' style='width: 20%' value='$email_add'/> 
    <br><br>
    <label style='padding-left: 355px'>First Name:</label><input type='text' placeholder='Put your First Name' id='fname'  readonly name='fname' style='width: 20%' value='$firstname'/>
    <label style='margin-left: 148px'></label>Password:<input type='password' placeholder='Update your Password' readonly name='pass' id='pass' style='width: 20%'/>
    <br><br>
    <label style='margin-left: 340px'>Middle Name:</label><input type='text' placeholder='Put your Middle Name' id='mid_name' readonly name='mid_name'   style='width: 20%' value='$mid_name'/>
    <label style='margin-left: 90px'>Confirm Password:</label><input type='password' placeholder='Re-type your New Password' readonly name='con_pass' id='con_pass' style='width: 20%'/>
    <br><br>
    <label style='padding-left: 358px'>Last Name:</label><input type='text' placeholder='Edit your Last name' id='last_name' readonly name='last_name'  style='width: 20%' value='$last_name'/>
    <label style='margin-left: 105px'>Contact Number:</label><input type='tel' placeholder='Please put your number' readonly name='numb' id='numb' style='width: 20%' value='$numb' maxlength='11'/>
    <br><br>
    <label style='padding-left: 372px'>Birthday:</label><input type='date' placeholder='Select Birthdate' id='bday' readonly name='bday' pattern='[A-Za-z]' style='width:20%' value='$bday'/>
    <label style='margin-left: 82px'>Emergency Number:</label></label><input type='tel' placeholder='Please put a Emergency Number' readonly name='numb2' id='numb2' style='width: 20%;' value='$numb2' maxlength='11'/>
    <br><br>
    <label style='padding-left: 375px'>Address:</label><input type='text' placeholder='Street/Block/Subdv No.' id='address' readonly name='address'   style='width: 20%' value='$address'/>";

$positionDropdown = "<label style='margin-left: 165px'>Position:</label><select id='posit' name='posit' style='width: 20%' required disabled>";

foreach ($positions as $position) {
    $positionId = $position['id'];
    $posName = $position['posname'];
    $selected = ($positionId == $userPositionId) ? 'selected': '';

    $positionDropdown .= "<option value='$positionId' $selected>$posName</option>";
}
$positionDropdown .= "</select>";
echo $positionDropdown;


echo"
<button class='edit' name='update_profile' onclick='return activateFields()' id='editButton' value='1'> EDIT </button>
<button type='reset' class='adduser1' name='addUser' id='addUser'> ADD USER </button> 

</div>
</td>
</table>
</form>
";


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
                    pass: '$pass',
                    email_add: '$email_add',
                    numb: '$numb',
                    con_pass: '$con_pass',
                    numb2: '$numb2',
                                       
                };
                
      
                function activateFields() {
           
                    let textFields = [
                        'username', 'fname', 'mid_name', 'last_name', 'bday', 'address', 'pass', 'email_add', 'numb','numb2', 'con_pass'];  
                    if(editable) { 
                        
                        if(!confirm('Are you sure you want to update this data?')) {
                            
                             let password = document.getElementById('pass').value;
                                 let confirmPassword = document.getElementById('con_pass').value;
                                 if (password !== confirmPassword){
                                     alert('password do not match');
                                    return originalValues;
                                 }
                                        textFields.forEach(textField => {
                                        document.getElementById(textField).value = originalValues[textField];                                     
                            });
                            return false;
                        }
                        return true;  
                        } else
                            textFields.forEach(textField => {
                                document.getElementById(textField).readOnly = false;
                                
                                   
                        });                         
                            document.getElementById('posit').disabled = false;
                            document.getElementById('editButton').innerHTML = 'Update'; 
                            editable = true;
                            return false;         
                        }
                        
                        document.getElementById('addUser').onclick = function() {
                        location.href = 'add_user.php';
                        };
                        
                   
                    </script>
        ";
?>




<?php
include 'sections/footer2.php';
?>