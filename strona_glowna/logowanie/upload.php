<?php

session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
if (!isset($_SESSION['loggedin']))
{
header('Location: index1.php');
exit();
}


$target_dir = "./users/" . $_SESSION['username'];
$target_file = $target_dir . "/". basename($_FILES["fileToUpload"]["name"]);
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){ 
    
    echo htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " uploaded."; 
    
    
    $time = date('H:i:s', time());
    $user = $_SESSION['username'];
    
$dbhost="localhost"; $dbuser="u781260265_mateuszlassa"; $dbpassword="zaq1@WSX"; $dbname="u781260265_dbml";
    $connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
    if (!$connection) {
        echo " MySQL Connection error." . PHP_EOL;
        echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    $result = mysqli_query($connection, "INSERT INTO messages (message, user) VALUES ('$target_file', '$user');") or die ("DB error: $dbname");
    mysqli_close($connection);

header ('Location: index2.php');
} else { 
    echo "Error uploading file."; 
}
?>