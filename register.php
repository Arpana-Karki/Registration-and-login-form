<?php

include("database.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
<div class="main-container">
<div class="container">
            <div class="image-container">
                <img src="signup.png" alt="Header Image">
            </div>
    <div class ="form-container">
    <form action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method ="post">

    <div>
    <label for ="user" >User Name :</label>
    <input type ="text" id ="user" name ="username" placeholder ="user name" >
    <div id="user-error" class="error-message"></div>
    </div>

    <div class ="password-container">
        <label for ="password" >Password :</label>
        <input type ="password"  name ="password" placeholder ="password" id="password" >
        <img src="eye-close.png" id="password-toggle" onclick="togglePasswordVisibility()">
        <div id="password-error" class="error-message"></div>

</div>

    <div>
        <label for ="email" >Email :</label>
        <input type ="email"  name ="email" placeholder ="email" >
        <div id="email-error" class="error-message"></div>
    </div>
    

    <div>
        <input type ="submit" name="submit" value ="Register" class="submitButton">
    </div>

    <div>
        <p class="question">Already registered ?</p>
        <button type="button" id ="login_button" onclick="redirectToLogin()">Login</button>
                 
            </div>
        </form>
        </div>
                    </div>
    </div>
</body>
</html>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    
   
        
        if (empty($username)) {
            echo "<script>displayErrorMessage('user', 'Please enter a username');</script>";
            
        } elseif (empty($password)) {
            echo "<script>displayErrorMessage('password', 'Please enter a password');</script>";
            
        } elseif (empty($email)) {
            echo "<script>displayErrorMessage('email', 'Please enter an email');</script>";
        }
        else{
            $table_name="user_registration";
            $existingUserQuery =  "SELECT * FROM $table_name WHERE user='$username' OR email='$email'";
            $existingUser =mysqli_query($conn , $existingUserQuery);
            
        
        
        if ($existingUser) {
            if (mysqli_num_rows($existingUser) > 0) {
                echo "<script>displayErrorMessage('user', 'This username/email is already taken. Please enter a new one.');</script>";
                
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO $table_name (user, password, email) VALUES ('$username', '$hash', '$email')";
                
                try {
                    if (mysqli_query($conn, $sql)) {
                       /* echo "Congrats! You have successfully registered to Smart finance as " . $user_role; */
                        header("Location: login.php");
                        exit;
                       
                    } else {
                        throw new Exception("Error executing query: " . mysqli_error($conn));
                    }
                
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
        } else {
            echo "Error executing query: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);

?>