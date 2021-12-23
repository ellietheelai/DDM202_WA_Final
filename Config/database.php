<?php
// used to connect to the database
$host = "sql313.epizy.com";
$db_name = "epiz_30655152_online_store";
$username = "epiz_30655152";
$password = "LiZABnRkWvYJH";
  
try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 
}
  
// show error
catch(PDOException $exception){
    echo "Connection error: ".$exception->getMessage();
}
?>
