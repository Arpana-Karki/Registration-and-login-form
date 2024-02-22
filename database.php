<?php

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name ="smart_finance";
$conn;

try{

    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    echo "You are connected";
}

catch (mysql_sql_exception){

    echo "oops!couldn't connect";
}


?>
