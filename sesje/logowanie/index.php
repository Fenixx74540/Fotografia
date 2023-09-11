<?php
session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
print $_SESSION['username'];
?>



<?php

session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
if (!isset($_SESSION['loggedin']))
{
    header('Location: index1.php');
    exit();
}

$dbhost="localhost"; $dbuser="u781260265_maria"; $dbpassword="zaq1@WSX"; $dbname="u781260265_fotografia";
$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
if (!$connection)
{
    echo " MySQL Connection error." . PHP_EOL;
    echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

mysqli_close($connection);
?>
<a href = "logout.php"> Logout </a>
