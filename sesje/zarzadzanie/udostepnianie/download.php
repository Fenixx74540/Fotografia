<?php 
    date_default_timezone_set('Europe/Warsaw');
    include('/home/u781260265/domains/mariakapsiak.pl/public_html/sesje/zarzadzanie/baza_danych/conn.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style_udostepnianie_download.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
</head>
<body>
    <div class="wrapper">
    <div class="download">
        <p class="download-text">
<?php
//sprawdzenie poprawności lniku czy pełna ścieżka/link do pliku download.php się zgadza i czy unikalny kod na końcu ma 40 znaków 0-9 A-F
if (isset($_GET["link"]) && preg_match('/^[0-9A-F]{40}$/i', $_GET["link"])) {
    $link = $_GET["link"]; // do zmiennej link wpisujemy pełen wtgenerowany link
}else{
    echo "<h1>Niepoprawny link.</h1>";
	exit();
}
//weryfikacja licznika pobrań 
$ct=0;
$currenttime= $_SERVER["REQUEST_TIME"];
$currentdate = date('d m Y H:i:s', $currenttime);

//formatowanie daty i czasu na ładny i standardowy w Polsce format wraz z nazwą dnia tygodnia
$formatter = new IntlDateFormatter(
    'pl_PL',
    IntlDateFormatter::FULL,
    IntlDateFormatter::FULL,
    date_default_timezone_get(),
    IntlDateFormatter::GREGORIAN,
    'EEEE, d MMMM yyyy'
);
echo  '<h1> Aktualna data i czas: </h1>';
echo '<i class="fa-solid fa-calendar-day"></i>';
echo '<h3>'.$formatter->format($currenttime).'</h3><br>';

// weryfikacja niezbędnych informacji z zapisanego linku do DB
$sql = ("SELECT * FROM links WHERE link= ? ") ;
$result = $conn->prepare($sql);
$result->execute([$link]);

//pobranie wybranych wierszy z tabeli po kolei, gdzie na końcu licznik pobrań jest zmiejszany o 1
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $linkdb = $row['link'];
    $filedownload = $row['file'];
    $tstamp = $row['tstamp'];
    $expire = $row['expire'];
    $counting = $row['counting'];
    $newcount=$counting-1;
    
    
    //konwersja daty na wygodniejszą do odczytania
    $date = date('d.m.Y - H:i:s', $expire);
    echo '<p>Link wygaśnie w tym terminie:  '.$date.'</p>';
    
    //sprawdzenie czy link nie wygasł
    if ($currenttime > $expire) {
        echo '<p>Niestety ale ten link już wygasł.<p>';
    // 	exit();
    // usunięcie linku z DB, żeby nie zajmował miejsca w DB bo i tak wygasł
        $sql = "DELETE FROM links WHERE link= ?";
	    $stmt=$conn->prepare($sql);
	    $stmt->execute([$link]);
    	exit();
    }
    
    // sprawdzenie czy podany link równa się temu zapisanemu w DB
    if ($linkdb==$link) {
        echo '<p>Pozostało '.$newcount.' do wygaśnięcia tego linku.</p>';
        $sql = "UPDATE links SET counting=? WHERE link=? ";
	    $stmt=$conn->prepare($sql);
	    $stmt->execute([$newcount,$linkdb]);
    	$ct=1;
    }
    else {
        echo "<h1>Link jest niepoprawny lub stracił swoją ważność i wygasł.</h1>";
    	exit();
    }
}

// usunięcie linku z DB, żeby nie użyć go ponownie
$sql = "DELETE FROM links WHERE link=? AND counting < '1'";
$stmt=$conn->prepare($sql);
$stmt->execute([$link]);


// ETAP POBIERANIA PLIKU
//ścieżka do pliku
if($ct==1){
    $path = ''; 
    $path = "files/$filedownload"; 
    echo $path;
    
    //sprawdzenie jaki mime typ danych będzie pobierany
    // MIME type to coś jak roszerzenie pliku
    $mime_type=mime_content_type($path); 
    
    //wymuszenie pobrania pliku przy pomocy header
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.$path.'"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($path)); //URL
    ob_clean(); // czyści bufor wyjściowy 
    flush(); // wysłanie danych do przeglądarki
    readfile($path); //odczytanie pliku z URL
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
</body>
</html>
