<?php
$dsn="mysql:host=localhost;dbname=php";
$username="root";
$password="";


try{

    $con= new PDO($dsn,$username,$password);
    echo "connected";
}


catch(PDOException $e){
echo $e;
}




?>