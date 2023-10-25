<?php 
    date_default_timezone_set('Europe/Warsaw');
    include('/home/u781260265/domains/mariakapsiak.pl/public_html/sesje/zarzadzanie/baza_danych/conn.php');
?>
<div class="container">
<div class="jumbotron"><p class="text-xl-center">
<?php
// retrieve link
if (isset($_GET["link"]) && preg_match('/^[0-9A-F]{40}$/i', $_GET["link"])) {
    $link = $_GET["link"];
}else{
    echo "<h1>Niepoprawny link.</h1>";
	exit();
}
//starting verification with the $ct variable
$ct=0;
$currenttime= $_SERVER["REQUEST_TIME"];
$currentdate = date('M d, Y h:i:s A', $currenttime);
echo  'Aktualna data i czas: '.$currentdate.'<br/>';
// verify link get necessary information we will need to preocess request
$sql = ("SELECT * FROM links WHERE link= ? ") ;
$result = $conn->prepare($sql);
$result->execute([$link]);
// while ($row = $result->fetch_assoc()) {
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $linkdb = $row['link'];
    $filedownload = $row['file'];
    $tstamp = $row['tstamp'];
    $expire = $row['expire'];
    $counting = $row['counting'];
    $newcount=$counting-1;
    
    
    //convert timestamp to readable date the show expiration date and time
    $date = date('M d, Y h:i:s A', $expire);
    echo 'Link wygaśnie w tym terminie:  '.$date.'<br/>';
    
    // Check to see if link has expired
    if ($currenttime > $expire) {
        echo "Niestety ale ten link już wygasł.";
    	exit();
    // delete link so it can't be used again
    // mysqli_query($conn,"DELETE FROM links WHERE link='$link' ");
        $sql = "DELETE FROM links WHERE link= ?";
	    $stmt=$conn->prepare($sql);
	    $stmt->execute([$link]);
    	exit();
    }
    
    if ($linkdb==$link) {
        echo 'Pozostało '.$newcount.' do wygaśnięcia tego linku.';
    // 	mysqli_query($conn,"UPDATE links SET counting='$newcount' WHERE link='$linkdb' ");
        $sql = "UPDATE links SET counting=? WHERE link=? ";
	    $stmt=$conn->prepare($sql);
	    $stmt->execute([$newcount,$linkdb]);
    	$ct=1;
    }
    else {
        echo "Link jest niepoprawny lub stracił swoją ważność i wygasł.";
    	exit();
    }
}

// delete link so it can't be used again
// mysqli_query($conn,"DELETE FROM links WHERE link='$link' AND counting < '1' ");
$sql = "DELETE FROM links WHERE link=? AND counting < '1'";
$stmt=$conn->prepare($sql);
$stmt->execute([$link]);

//FILE DOWNLOAD
//path to file
if($ct==1){
    $path = ''; 
    $path = "files/$filedownload"; 
    echo $path;
    
    $mime_type=mime_content_type($path); 
    
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.$path.'"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($path)); //Absolute URL
    ob_clean();
    flush();
    readfile($path); //Absolute URL
    exit();
}else{
	echo '<p>Plik został już pobrany maksymalną ilość razy z tego linku.</p>';
}
?>
</p>
</div>
<?php 
    $conn = null;
?>