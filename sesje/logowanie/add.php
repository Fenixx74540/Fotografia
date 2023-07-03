<?php
session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
if (!isset($_SESSION['loggedin']))
{
header('Location: index1.php');
exit();
}

$time = date('H:i:s', time());
$user = $_SESSION['username'];
$post = $_POST['post'];
echo $_POST['post'];
if (IsSet($_POST['post'])) {
    $dbhost="localhost"; $dbuser="u781260265_mateuszlassa"; $dbpassword="zaq1@WSX"; $dbname="u781260265_dbml";
    $connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
    if (!$connection) {
        echo " MySQL Connection error." . PHP_EOL;
        echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    $result = mysqli_query($connection, "INSERT INTO messages (message, user) VALUES ('$post', '$user');") or die ("DB error: $dbname");
    mysqli_close($connection);
} else {
    echo "There is no post message";
}
header ('Location: index2.php');
?>
