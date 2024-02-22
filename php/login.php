<?php

include("database.php");
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
<div class="main-container">
    <div class="container">
        <div class ="form-container">
        <div class="loginImage-container">
            <img src="login.png" alt="Header Image">
        </div>
        <form action="login.php" method="post">

            
        <div>
            
            <div>
                <label for ="email" >Email :</label>
                <input type ="email"  name ="email" placeholder ="email" >
                <div id="email-error" class="error-message"></div>
            </div>
            
            <div>
                <label for ="password" >Password :</label>
                <input type ="password"  name ="password" placeholder ="password" id="password" >
                <img src="eye-close.png" id="password-toggle" onclick="togglePasswordVisibility()">
                <div id="password-error" class="error-message"></div>
            </div>
            
            
            <div>
                <input type ="submit" name="submit" value ="Login"  class="submitButton">
            </div>
            
            <div>
                <p class="question">Haven't registered yet ? <p>
                    <button type="button" id ="register_button" onclick="redirectToRegister()">Register</button>
                </div>
            </form>
        </div>
                    </div>
    </div>   
</body>
</html>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST["submit"])) {
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    
    
    $table_name="user_registration";
    if (empty($password)) {
        echo "<script>displayErrorMessage('password', 'Please enter a password');</script>";

    } elseif (empty($email)) {
        echo "<script>displayErrorMessage('email', 'Please enter an email');</script>";

    } else {
        $existingUser = mysqli_query($conn, "SELECT * FROM $table_name WHERE  email='$email'");
        
        if (!$existingUser) {
            echo "Error: " . mysqli_error($conn); 
            exit();
        }
        
        if($existingUser && $row = mysqli_fetch_assoc($existingUser)){
            $hashedPasswordFromDatabase = $row['password'];
         

           

            if (password_verify($password,$hashedPasswordFromDatabase )) {
            $_SESSION['user_id']=$row['id'];
            header('Location:dashboard.php');
            exit();
        }
        else{
            echo "<script>displayErrorMessage( 'password', 'Incorrect email or password. Please try again.');</script>";
            exit();
            }
        
        }
        else {
            echo "<script>displayErrorMessage('email', 'User with this email doesn\'t exist.');</script>";
            exit();
        }
     }
}

mysqli_close($conn);

?>