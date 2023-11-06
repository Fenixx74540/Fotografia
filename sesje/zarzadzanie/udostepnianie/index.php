<?php 
    date_default_timezone_set('Europe/Warsaw');
    include('/home/u781260265/domains/mariakapsiak.pl/public_html/sesje/zarzadzanie/baza_danych/conn.php');
    if(isset($_POST['submit'])){
    	$errors= array();
        $file_name = $_FILES['file']['name'];
        $file_size =$_FILES['file']['size'];
        $file_tmp =$_FILES['file']['tmp_name'];
        $file_type=$_FILES['file']['type'];
    	$fileend=explode('.',$file_name);
        $file_ext=strtolower(end($fileend));
          
        $extensions= array("jpeg","jpg","png","heif","zip","tar","7z","rar","gz");
          
        if(in_array($file_ext,$extensions)=== false){
            $errors[]="ten rodzaj pliku nie jest dozwolony, wybierz coś z rozszerzeniem: jpeg, jpg, png, heif, zip, tar, 7z, rar, gz";
        }
          
        if($file_size > 16106127360){
            $errors[]='Maksymalny rozmiar pliku to 15GB';
        }
          
        if(empty($errors)==true){
            move_uploaded_file($file_tmp,"files/".$file_name);
            //echo "Success";
        }else{
            print_r($errors);
        }
       
       
        $expire=$_POST['date'];
        $counting=$_POST['counting'];
        $date = date('M d, Y h:i:s A', strtotime($expire));
        $dbdate = date('Y M d H:i:s', strtotime($expire));
        $one= 'Link wygaśnie w tym terminie: '.$date.'<br/>';
        $d = DateTime::createFromFormat(
            'Y M d H:i:s',
            $dbdate,
            new DateTimeZone('EST')
        );
        
        if ($d === false) {
            die("Incorrect date string");
        } else {
            $expiredate=$d->getTimestamp();
        }
        
        $link = sha1(uniqid($file_name, true));
        
        $tstamp=$_SERVER["REQUEST_TIME"];
        
        // mysqli_query($conn,"INSERT INTO links(`link`,`file`, `counting`, `expire`, `tstamp`)
        // VALUES ('$link', '$file_name', '$counting','$expiredate','$tstamp')");
        
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
        
        $two= '<a href="https://mariakapsiak.pl/sesje/zarzadzanie/udostepnianie/download.php?link='.$link.' " target="_NEW">Link</a>';
    }
?>

<html>
<head>
    <title>Link do pobrania zdjęć</title>
    <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" >-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link href="style_udostepnianie.css" rel="stylesheet" type="text/css" >
</head>
<body>
    <div class="wrapper">
        <div class="jumbotron"><p class="text-xl-center"><?php if(isset($one)){echo $one.$two;};?></p></div>
            <h1><span class="fa-solid fa-link"></span> Wygeneruj link do pobrania zdjęć</h1>
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">	
                	<form method="post" role="form" enctype="multipart/form-data">
                	<div class="input-box">
                	    <label for="file">Wybierz paczkę zdjęć do udostępnienia:</label>
                	    <input type="file" name="file" required>
                    </div>
            	    <div class="input-box">
            	        <label for="counting">Ustaw ile razy może być pobrane z tego linku:</label>
            	        <input type="tel" name="counting" required>
            	    </div>
            	    <div class="input-box">
            	        <label for="date">Ustaw do kiedy link ma być ważny:</label><br>
            	        <!--<span class="datepicker-toggle">-->
                     <!--       <span class="datepicker-toggle-button"></span>-->
                     <!--       <input type="datetime-local" class="datepicker-input" name="date" required>-->
                     <!--   </span>-->
            	        <input type="datetime-local" class="datepicker-input" name="date" required>
            	    </div>
            	    <input type="submit" name="submit" class="btn" value="Udostępnij" />
            	    </form>
            	</div>
            <div class="col-sm-4"></div>
        </div>
    </div>
</body>

<?php 
    $conn = null;
?>