<?php 
	include 'baza_danych/conn.php';
	date_default_timezone_set('Europe/Warsaw');

    if(isset($_GET["del"])){
	    @$id=intval($_GET['id']);
	    @$name=$_GET["name"];
	    $sql = "DELETE FROM images WHERE id=?";
	    $stmt=$conn->prepare($sql);
	    @unlink('/home/u781260265/domains/mariakapsiak.pl/public_html/sesje/zdj/'.$name);
	    header('Location: ' . $_SERVER['HTTP_REFERER']);
	    $stmt->execute([$id]);
	    $x=$stmt->fetch(PDO::FETCH_OBJ);
	}

	$sql  = "SELECT * FROM images ORDER BY id DESC";

	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$images = $stmt->fetchAll();
	

 ?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Maria Kapsiak- Zarządzaj</title>
        <link rel="stylesheet" href="style_zarzadzanie.css">

    </head>
    <body>
        <div class="wrapper">
            <div class="btn">
                <a href="logowanie/register.php"> Zarejestruj nowe konto </a><br><br>
                <a href="udostepnianie/index.php"> Udostępnij zdjęcia </a>
            </div>
            
            <h1>Zalogowany użytkownik: </h1>
        
            <?php
                session_start();
                $user = $_SESSION["username"];
                echo '<h5>' . $user . '</h5>';
            ?>

            <div class="btn">
                <a href = "logowanie/logout.php"> WYLOGUJ</a>
            </div>
        
            <form method="POST" action="upload.php" enctype="multipart/form-data">
                <?php
                    if (isset($_GET['error'])) {
                        echo "<p style='color: red'>";
                            echo htmlspecialchars($_GET['error']);
                        echo "</p>";
                    }
                ?>
                <h2>Wybierz zdjęcia do przesłania</h2>
                <div class="input-box">
                    <input type="file" id="getFile" name="images[]" multiple>
                </div>
                <button type="submit" name="upload">Wyślij</button>
            </form>
        </div>
            
            
            
        
        <?php if ($stmt->rowCount() > 0) { ?>
        	<div class="gallery">
        		<h4>Wszystkie zdjęcia w galerii</h4>
        		<?php foreach ($images as $image) { ?>
        		        <img src="/sesje/zdj/<?=$image['img_name']?>">
        		        <a href="?del&id=<?=$image['id']?>&name=<?=$image['img_name']?>"><buton style="color:red" typ="submit">Usuń</buton></a>
        		<?php } ?>
        	</div>
	    <?php } ?>
    </body>
</html>



