<?php 
    date_default_timezone_set('Europe/Warsaw');
    include('/home/u781260265/domains/mariakapsiak.pl/public_html/sesje/zarzadzanie/baza_danych/conn.php');
    if(isset($_POST['submit'])){
    	$errors= array();
        $file_name = $_FILES['file']['name'];
        $file_size =$_FILES['file']['size'];
        $file_tmp =$_FILES['file']['tmp_name'];
        $file_type=$_FILES['file']['type'];
    	$fileend=explode('.',$file_name); // podzielenie stringu tam, gdzie jest kropka
        $file_ext=strtolower(end($fileend)); // zamiana na małe litery
          
        $extensions= array("jpeg","jpg","png","heif","zip","tar","7z","rar","gz");
          
        if(in_array($file_ext,$extensions)=== false){
            $errors[]="ten rodzaj pliku nie jest dozwolony, wybierz coś z rozszerzeniem: jpeg, jpg, png, heif, zip, tar, 7z, rar, gz";
        }
          
        if($file_size > 16106127360){ // podane w bajtach
            $errors[]='Maksymalny rozmiar pliku to 15GB';
        }
          
        if(empty($errors)==true){
            move_uploaded_file($file_tmp,"files/".$file_name);
            //echo "Działa";
        }else{
            print_r($errors);
        }
       
       
        $expire=$_POST['date']; //data wygaśnięcia linku
        $counting=$_POST['counting']; // licznik pobrań 
        $date = date('d.m.Y - H:i:s', strtotime($expire)); // data wyświetlana w normlanym ludzkim formacie
        $dbdate = date('d m Y H:i:s', strtotime($expire)); // data wpisywana do bazy danych 
        $one= 'Link wygaśnie w tym terminie: '.$date.'<br/>';
        
        $d = DateTime::createFromFormat(
            'd m Y H:i:s',
            $dbdate,
            new DateTimeZone('Europe/Warsaw')
        );
        
        if ($d === false) {
            die("Niepoprawny format daty");
        } else {
            $expiredate=$d->getTimestamp();
        }
        
        $link = sha1(uniqid($file_name, true));
        
        $tstamp=$_SERVER["REQUEST_TIME"]; // aktualny czas serwera
        
        // wpisanie danych do DB 
        $sql = "INSERT INTO links(`link`,`file`, `counting`, `expire`, `tstamp`) VALUES (:link, :file_name, :counting, :expiredate, :tstamp)";
        $stmt = $conn->prepare($sql);
        $data = [
            ':link' => $link,
            ':file_name' => $file_name,
            ':counting' => $counting,
            ':expiredate' => $expiredate,
            ':tstamp' => $tstamp,
        ];
        $stmt->execute($data);
        
        // pełna ścieżka/link do pliki dowlonad.php, gdzie na końcu będzie dopisany unikalny numer linku do pobrania otwarty w nowej stronie 
        $two= '<a href="https://mariakapsiak.pl/sesje/zarzadzanie/udostepnianie/download.php?link='.$link.' " target="_NEW">Pobierz zdjęcia</a><br>';
        
        echo '<label id="link-to-copy">https://mariakapsiak.pl/sesje/zarzadzanie/udostepnianie/download.php?link=' . $link . '</label>';
    }
?>

<html>
<head>
    <title>Wygeneruj link</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link href="style_udostepnianie.css" rel="stylesheet" type="text/css" >
</head>
<body>
    <div class="wrapper">
        <div class="download">
            <p class="download-text"><?php if(isset($one)){echo $one.$two;};?></p>
            
            
            <!--<button id="btn-copy" class="btn">Skopiuj link</button>-->
            <div id="btnHolder"></div>
    
        </div>

        
        <h1><span class="fa-solid fa-link"></span> Wygeneruj link do pobrania zdjęć</h1>
        <div class="container">	
        	<form method="post" role="form" enctype="multipart/form-data">
        	<div class="input-box">
        	    <label for="file">Wybierz paczkę zdjęć do udostępnienia:</label>
        	    <input type="file" name="file" id="shared-file" required>
            </div>
    	    <div class="input-box">
    	        <label for="counting">Ustaw ile razy może być pobrane z tego linku:</label>
    	        <input type="tel" name="counting" id="shared-count" required>
    	    </div>
    	    <div class="input-box">
    	        <label for="date">Ustaw do kiedy link ma być ważny:</label><br>
    	        <input type="datetime-local" class="datepicker-input" name="date" id="shared-date" required>
    	    </div>
    	    <!---->
    	    <div id="btnOne">
    	        <input type="submit" name="submit" class="btn" id="btn-share" value="Udostępnij" onClick="javascript:addBtn();" />
    	    </div>
    	    </form>
        </div>
    </div>
    <script type="text/JavaScript">
    // kopiowanie linku z przycisku
    document.getElementById("btn-copy").onclick = function() {
    	copyToClipboard(document.getElementById("link-to-copy"));
    }
    
    
    function copyToClipboard(e) {
        var tempItem = document.createElement("input");
    
        tempItem.setAttribute("type","text");
        tempItem.setAttribute("display","none");
        
        let content = e;
        if (e instanceof HTMLElement) {
        		content = e.innerHTML;
        }
        
        tempItem.setAttribute("value",content);
        document.body.appendChild(tempItem);
        
        tempItem.select();
        document.execCommand("Copy");
    
        tempItem.parentElement.removeChild(tempItem);
    }
    
    
    
    
    
    // TO DO CHOWANIE PRZYCISKU 
    
    
    
    
    
    
    
    //Pokaż / Schowaj przycisk kopiowania linku
    setTimeout(addBtn, 2000);
    function addBtn(){
        document.getElementById('btnHolder').innerHTML = '<button id="btn-copy" class="btn" onClick="javascript:removeBtn();" value="click">Skopiuj link</button> ';
    }
    
    
    // function removeBtn(){
    //     document.getElementById('btnHolder').innerHTML = '';
    // }
    </script>
    
</body>
</html>
<?php 
    $conn = null;
?>