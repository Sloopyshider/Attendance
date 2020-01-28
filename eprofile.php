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
    $pass = $_POST ['pass'];
    $email_add = $_POST ['email_add'];
    $posit = $_POST ['posit'];
    $numb = $_POST ['numb'];
    $con_pass = $_POST ['con_pass'];







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
                    `contact`=:numb 
                    
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
        ':id' => $id

    ];

    $stmt =  $conn->prepare($stmt);
    $pdoExc =  $stmt->execute($parameters);

    $pass = password_hash('$pass', PASSWORD_DEFAULT);

    if ($_POST['pass'] !== $_POST ['con_pass']){
        echo '<script>alert("Password not match")</script>';
        header('e.profile.php');
    }else{
        echo '<script>alert("Success!")</script>';
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


?>

    <head>

        <title> Employee Profile </title>
        <link href='cssfiles/main.css' rel='stylesheet' type='text/css'>
    </head>
    <body>

<?php



echo "
        
<hr>
<label class='userdetails'> User Details </label>
<form action='eprofile.php' method='post'>

<img src='avatar1.jpg' id='dp' class='editAvatar' alt='dp'>
 

<label
    <label class='personal'></label>
    <table class='table2'>
         <th>
                <input type='hidden' placeholder='id' name='id' id='id' value='$userId'>          
                Username <input type='text' placeholder='Edit your Username' id='username' readonly name='username'  style='width: 100%' value='$userName'/>
            <br>
            <br>
                First name<input type='text' placeholder='Put your First Name' id='fname'  readonly name='fname'  style='width: 100%'  value='$firstname'/>
            <br>
            <br>
                Middle Name<input type='text' placeholder='Put your Middle Name' id='mid_name' readonly name='mid_name'   style='width: 100%' value='$mid_name'/>
            <br>
            <br>
                Last Name<input type='text' placeholder='Put your Last Name' id='last_name' readonly name='last_name' style='width: 100%' value='$last_name'/>
            <br>
            <br>  
                Birthday<input type='date' placeholder='Select Birthdate' id='bday' readonly name='bday'  style='width: 100%' value='$bday'/>
            <br>
            <br>
                Address<input type='text' placeholder='Street/Block/Subdv No.' id='address' readonly name='address'   style='width: 100%' value='$address'/>
            <br>
            <br>
                City<input type='text' placeholder='City' readonly name='city' id='city'   style='width: 100%' value='$city'/>
       </th>

   
    </table>
    
    
    <form name='formChange' method='post' action='' onsubmit='return validatePassword()'>
    <table class='table3'>
        <th> 
        
             Password<input type='password' placeholder='Update your Password' readonly name='pass' onsubmit='' id='pass' style='width: 100%' value='$pass'/>
            <br> <br>
            Confirm Password<input type='password' placeholder='Re-type your New Password' readonly name='con_pass' id='con_pass' style='width: 100%' value='$pass'/>
            <br> <br>
            
        </th>
        </form>
    
    <table class='table4'>
        <th>
                Email<input type='email' placeholder='Put your Email'  readonly name='email_add' id='email_add' style='width: 100%' value='$email_add'/>
            <br>
            <br>";



$positionDropdown = "Position<select id='posit' name='posit' style='width: 100%' required disabled>";

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
                Mobile Number<input type='tel' placeholder='Please put your number' readonly name='numb' id='numb' style='width: 100%' value='$numb' maxlength='11'/>
            <br>
        </th> 

        <button class='edit' name='update_profile' onclick='return activateFields()' id='editButton' value='1'> EDIT </button>
        
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
                    con_pass: '$con_pass',
                                       
                };
                
      
                function activateFields() {
           
                    let textFields = [
                        'username', 'fname', 'mid_name', 'last_name', 'bday', 'address', 'city', 'pass', 'email_add', 'numb', 'con_pass'];  
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