<?php

$host="localhost";
$user="root";
$pass="";
$db="login";
$port="3307"; 
$conn=new mysqli($host, $user, $pass, $db, $port);
if($conn->connect_error){
    echo "Failed to connect DB".$conn->connect_error;
}

?>