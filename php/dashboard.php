<?php

include("database.php");

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
</head>
<body>
    <form action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method ="post">

    <div>
       <p>Welcome to Smart Finance !</p>
    </div>
    <div>
        <button type="button" id ="logout_button" onclick="redirectToLogin()">Logout</button>
        <script>
            function redirectToLogin(){
                window.location.href="login.php"
            }
        </script>
        </div>
    
    

