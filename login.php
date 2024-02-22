<?php

include("database.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method ="post">

    <div>

    <div>
        <label for ="password" >Password :</label>
        <input type ="password"  name ="password" placeholder ="password" >
    </div>

    <div>
        <label for ="email" >Email :</label>
        <input type ="email"  name ="email" placeholder ="email" >
    </div>
    <div>
        <label for ="user_role" >Login as:</label>
        <label>
            <input type ="radio"  name ="user_role" value ="User" checked >User
        </label>
        <label>
            <input type ="radio" name="user_role" value ="Admin">Admin
        </label>
    </div>
    
    <div>
        <input type ="submit" name="submit" value ="Login">
    </div>

    <div>
        <p>Haven't registered yet ? <p>
        <button type="button" id ="register_button" onclick="redirectToRegister()">Register</button>
        <script>
            function redirectToRegister(){
                window.location.href="register.php"
            }
        </script>
        </div>

</body>
</html>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    
    if($user_role =="User"){ 
        $table_name="user_registration";
    }

    else{
        $table_name="register";

    }

    if (empty($password)) {
        echo "Please enter a password";
    } elseif (empty($email)) {
        echo "Please enter an email";
    } else {
        $existingUser = mysqli_query($conn, "SELECT * FROM $table_name WHERE password='$password' OR email='$email'");
        
        if($existingUser && $row = mysqli_fetch_assoc($existingUser)){
            $_SESSION['user_id']=$row['id'];
            header('Location:dashboard.php');
            exit();
        }
        else{
            echo"Incorrect Username or Password.Please try again.";
        }
        

    }
}

mysqli_close($conn);

?>