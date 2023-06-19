<?php
session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
print $_SESSION['username'];
?>
<form method="POST" action="add.php"><br>
Post:<input type="text" name="post" maxlength="90" size="90"><br>
<input type="submit" value="Send"/>
</form>

<form action="upload.php" method="post" enctype="multipart/form-data">
 Select file to upload:
 <input type="file" name="fileToUpload" id="fileToUpload">
 <input type="submit" value="Upload" name="submit">
</form>


<?php

session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
if (!isset($_SESSION['loggedin']))
{
    header('Location: index1.php');
    exit();
}

$dbhost="localhost"; $dbuser="u781260265_mateuszlassa"; $dbpassword="zaq1@WSX"; $dbname="u781260265_dbml";
$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
if (!$connection)
{
    echo " MySQL Connection error." . PHP_EOL;
    echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
$result = mysqli_query($connection, "Select * from messages") or die ("DB error: $dbname");
print "<TABLE CELLPADDING=5 BORDER=1>";
print "<TR><TD>id</TD><TD>Date/Time</TD><TD>User</TD><TD>Message</TD></TR>\n";
while ($row = mysqli_fetch_array ($result)) {
    $id = $row[0];
    $date = $row[1];
    $message= $row[2];
    $user = $row[3];
    if(strncmp($row[2], "./users/", 8) !== 0){
        print "<TR><TD>$id</TD><TD>$date</TD><TD>$user</TD><TD>$message</TD></TR>\n";
    } else {
        print "<TR>";
        print "<TD>$id</TD>";
        print "<TD>$date</TD>";
        print "<TD>$user</TD>";
        print "<TD>";
        $extension = pathinfo($message, PATHINFO_EXTENSION);
        $filename = pathinfo($message, PATHINFO_FILENAME);
        $dirname = pathinfo($message, PATHINFO_DIRNAME);
        switch ($extension){
            case "jpg":
            case "gif":
            case "png":
                print "<img src=\"$message\" alt=\"Zdjęcie\" style=\"min-width:180px;max-width:360px;min-height:180px;max-height:640px;\">";
                break;
            case "mp3":
            case "wav":
                print "<audio id=\"audio\" muted autoplay controls>
                <source src=$message>
                Your browser does not support the audio element.
              </audio>";
                break;
            case "mp4":
                print "<video controls muted autoplay style=\"background:black;min-width:180px;max-width:360px;min-height:180px;max-height:640px;\">
                <source src=\"$message\" type=\"video/mp4\">
              Your browser does not support the video tag.
              </video>";
                break;
            case "avi":
                break;
        }
        print "</TD></TR>\n";
    }
}
print "</TABLE>";
mysqli_close($connection);
?>
<a href = "logout.php"> Logout </a>
