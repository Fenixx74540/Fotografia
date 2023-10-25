<?php

$dbhost="localhost"; 
$dbuser="u781260265_maria"; 
$dbpassword="zaq1@WSX"; 
$dbname="u781260265_fotografia";

try {
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Błąd połączenia z bazą danych: " . $e->getMessage();
}



// $conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname); 
// if (!$conn) {
//     echo " MySQL Connection error." . PHP_EOL;
//     echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
//     echo "Error: " . mysqli_connect_error() . PHP_EOL;
//     exit;
// }


?>