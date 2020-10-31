<?php
session_start();

if(isset($_POST) && !empty($_POST)){

    $conn = mysqli_connect('localhost', 'root', 'root', 'login-reg');

    $errors = [];

    if($_POST['email'] == ""){
        array_push($errors, "Email required");
    }

    if($_POST['password'] == ""){
        array_push($errors, "Password required");
    }

    // snitize the post data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if(empty($errors)){
        // check user based on email and password in DB
        $password = md5($password);
        $user_check = "SELECT * FROM  users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $user_check);
        if(mysqli_num_rows($result) == 1){
            $_SESSION['msg'] = "You are logged in";
            header('location: home.php');
        }else{
            array_push($errors, "Email or Password did not match");
        }   
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_SESSION['msg'])){ ?>
            <h2><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></h2>
    <?php
        }
    ?>
    <?php include('error.php'); ?>
    <h3>Login</h3>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        </br></br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        </br></br>
        <button type="submit">Login</button>
    </form>
</body>
</html>