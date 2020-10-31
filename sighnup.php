<?php
session_start();
$conn = mysqli_connect('localhost', 'root', 'root', 'login-reg');

if(!$conn){
    die('Can not connect to database');
}

if(isset($_POST['signup'])){
    $errors = [];
    $chk_err = ["fname", 'lname', "email", "phone", "code", "password"];
    
    if($_POST['fname'] == ""){
        array_push($errors, "First Name required");
    }

    if($_POST['lname'] == ""){
        array_push($errors, "Last Name required");
    }

    if($_POST['email'] == ""){
        array_push($errors, "Email required");
    }

    if($_POST['code'] == ""){
        array_push($errors, "Code is required");
    }

    if($_POST['phone'] == ""){
        array_push($errors, "Phone is required");
    }

    if($_POST['password'] == ""){
        array_push($errors, "Password required");
    }

    // sanitize the post data
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $code = mysqli_real_escape_string($conn, $_POST['code']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);


    // check if user not already in DB with same email
    $user_check = "SELECT * FROM  users WHERE email='$email'";
    $result = mysqli_query($conn, $user_check);
    if($user = mysqli_fetch_assoc($result)){
        array_push($errors, "Email already exists");
    }
    
    if(empty($errors)){
        // insert user
        $password = md5($password);
        $insert = "INSERT INTO users (first_name, last_name, email, country_code, phone, password) 
        VALUES('$fname', '$lname', '$email', '$code', '$phone', '$password')";
        //die($insert);
        mysqli_query($conn, $insert);
        $_SESSION['msg'] = "Success";
        header('location: login.php');
    }
}
$country_codes = "SELECT * FROM  countries";
$result = mysqli_query($conn, $country_codes);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include('errors.php'); ?>
    <h3>Sign up</h3>
    <form action="sighnup.php" method="post">
        <label for="fname">fname:</label>
        <input type="text" name="fname" required>
        </br></br>

        <label for="lname">lname:</label>
        <input type="text" name="lname" required>
        </br></br>

        <label for="email">Email:</label>
        <input type="email" name="email" required>
        </br></br>

        <label for="code">Country Code:</label>
        <select name="code" required>
        <?php 
            $data = [];
            while($row = mysqli_fetch_assoc($result)){
                foreach($row as $key => $value){
            ?>
        
            <option value="<?php echo $row['id']; ?>"><?php echo $row['country_name']. " " .$row['country_code']; ?></option>
        
        <?php
                }
            }
        ?>
        </select>
        </br></br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" required>
        </br></br>

        <label for="password">Password:</label>
        <input type="password" name="password" required>
        </br></br>

        <label for="cpassword">Confirm Password:</label>
        <input type="password" name="cpassword" required>
        </br></br>
        <input type="submit" name="signup" value="Sign up">
    </form>
</body>
</html>