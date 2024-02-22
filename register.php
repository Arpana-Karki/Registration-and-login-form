<?php

include("database.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <form action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method ="post">

    <div>

    <div>
    <label for ="user" >User Name :</label>
    <input type ="text" id ="user" name ="username" placeholder ="user name" >
    </div>

    <div>
        <label for ="password" >Password :</label>
        <input type ="password"  name ="password" placeholder ="password" >
    </div>

    <div>
        <label for ="email" >Email :</label>
        <input type ="email"  name ="email" placeholder ="email" >
    </div>
    
    <div>
        <label for ="user_role" >Register as:</label>
        <label>
            <input type ="radio"  name ="user_role" value ="User" checked >User
        </label>
        <label>
            <input type ="radio" name="user_role" value ="Admin">Admin
        </label>
    </div>

    <div>
        <input type ="submit" name="submit" value ="Register">
    </div>

    <div>
        <p>Already registered ?</p>
        <button type="button"id ="login_button" onclick="redirectToLogin()">Login</button>
        <script>
            function redirectToLogin(){
                window.location.href="login.php"
            }
        </script>

</body>
</html>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    $user_role = $_POST["user_role"];

    if($user_role =="User"){ 
        $table_name="register";
    }

    else{
        $table_name="user_registration";

    }

    if (empty($username)) {
        echo "Please enter a username";
    } elseif (empty($password)) {
        echo "Please enter a password";
    } elseif (empty($email)) {
        echo "Please enter an email";
    } else {
        $existingUser = mysqli_query($conn, "SELECT * FROM $table_name WHERE user='$username' OR email='$email'");
        

        if ($existingUser) {
            if (mysqli_num_rows($existingUser) > 0) {
                echo "This username/email is already taken. Please enter a new one.";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                    
                    $sql = "INSERT INTO $table_name (user, password, email) VALUES ('$username', '$hash', '$email')";
                
                try {
                    if (mysqli_query($conn, $sql)) {
                       /* echo "Congrats! You have successfully registered to Smart finance"; */
                       /* sending registration email to the user */
                       
                        $to =$email;
                        $subject="New Registration to smart finance";
                        $message="A new user has registered.\nUsername: $username\nEmail: $email";
                        $header= "From: arpanakarki561@gmail.com";

                        ini_set("SMTP", "smtp.gmail.com");
                        ini_set("smtp_port", "587");

                        ini_set("sendmail_from", "arpanakarki561@gmail.com");

                        $mailSent=mail($to, $subject, $message, $header);
                            
                            if($mailSent){
                                echo"Congrats you have successfully registered to smart finanace.Email sent";
                            }
                            else{
                                echo "email not sent";
                            }

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