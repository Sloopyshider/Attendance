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
    $city = $_POST ['city'];
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
                    `city`=:city,
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
            ':city' => $city,
            ':numb' => $numb,
            ':id' => $id,
            ':numb2' => $numb2
        ];

        $stmt =  $conn->prepare($stmt);
        $pdoExc =  $stmt->execute($parameters);

//        $pass = password_hash('$pass', PASSWORD_DEFAULT);
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
$con_pass = $user ['password'];
$numb2 = $user ['sub_contact']


?>

    <head>

        <title> Employee Profile </title>
        <link href='cssfiles/main.css' rel='stylesheet' type='text/css'>
    </head>
    <body>

<?php



echo "
        
<hr>
<br>
<!--
<div class='container-e'>
<label class='userdetails'> User Details </label>
<br><br>
<form action='eprofile.php' method='post'>
        
                <input type='hidden' placeholder='id' name='id' id='id' value='$userId'> 
                
                <label class='label-e' for='username'> Username: </label>  
                <div class='col-emp'>       
                 <input type='text' placeholder='Edit your Username' id='username' readonly name='username'  style='width: 30%' value='$userName'/> 
                </div>
            
                
                <label class='label-e' for='fname'> First Name: </label>
                <div class='col-emp'>
                <input type='text' placeholder='Put your First Name' id='fname'  readonly name='fname'  style='width: 30%'  value='$firstname'/> 
                </div>
                
               
                <label class='label-e' for='mid_name'> Middle Name: </label>
                 <div class='col-emp'>
                <input type='text' placeholder='Put your Middle Name' id='mid_name' readonly name='mid_name'   style='width: 30%' value='$mid_name'/> 
                </div>
               
                
                <label class='label-e' for='last_name'> Last Name: </label>
                <div class='col-emp'>
                <input type='text' placeholder='Put your Last Name' id='last_name' readonly name='last_name' style='width: 30%' value='$last_name'/> 
                </div>
                
               
                <label class='label-e' for='bday'> Birthday: </label> 
                 <div class='col-emp'> 
                <input type='date' placeholder='Select Birthdate' id='bday' readonly name='bday'  style='width: 30%' value='$bday'/> 
                </div>
              
                
                <label class='label-e' for='address'> Address: </label>
                <div class='col-emp'>
                <input type='text' placeholder='Street/Block/Subdv No.' id='address' readonly name='address'   style='width: 30%' value='$address'/> 
                </div>
                
                <label class='label-e' for='city'> City: </label>
                <div class='col-emp'>
                <input type='text' placeholder='City' readonly name='city' id='city'   style='width: 30%' value='$city'/> 
                </div> 
                
                 <label class='label-ryt' for='pass'> Password: </label>
                 <div class='col-ryt'>     
                 <input type='password' placeholder='Update your Password' readonly name='pass' onsubmit='' id='pass' style='width: 30%'/>    
                 </div>
                 
                 <label class='label-ryt' for = 'con_pass'> Confirm Password: </label>
                 <div class='col-ryt'>
                 <input type='password' placeholder='Re-type your New Password' readonly name='con_pass' id='con_pass' style='width: 30%'/>
                </div>
                
                <label class='label-ryt' for='email_add'> Email Address</label>
                <div class='col-ryt'>
                <input type='email' placeholder='Put your Email'  readonly name='email_add' id='email_add' style='width: 30%' value='$email_add'/>
                </div>";


$positionDropdown = "<label class='label-ryt' for='posit'>Position: </label> 
                      <div class='col-ryt'> 
<select id='posit' name='posit' style='width: 30%' required disabled>";

foreach ($positions as $position) {
    $positionId = $position['id'];
    $posName = $position['posname'];
    $selected = ($positionId == $userPositionId) ? 'selected': '';

    $positionDropdown .= "<option value='$positionId' $selected>$posName</option>";
}
$positionDropdown .= "</select> </div>";
echo $positionDropdown;


echo "
            <label class='label-ryt' for='numb'> Contact Number: </label>
            <div class='col-ryt'>
                  <input type='tel' placeholder='Please put your number' readonly name='numb' id='numb' style='width: 30%' value='$numb' maxlength='11'/>
                  </div>
                  
            <label class='label-ryt' for='numb2'> Input another Contact: </label>
            <div class='col-ryt'>
                <input type='tel' placeholder='Please put your second number' readonly name='numb2' id='numb2' style='width: 30%' value='$numb2' maxlength='11'/>
            </div>
        
        <button class='edit' name='update_profile' onclick='return activateFields()' id='editButton' value='1'> EDIT </button>  
        
</form>
</div>";





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
                    con_pass: '$con_pass',
                    numb2: '$numb2',
                                       
                };
                
      
                function activateFields() {
           
                    let textFields = [
                        'username', 'fname', 'mid_name', 'last_name', 'bday', 'address', 'city', 'pass', 'email_add', 'numb','numb2', 'con_pass'];  
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
                   
                    </script>
        ";
?>




<?php
include 'sections/footer2.php';
?>