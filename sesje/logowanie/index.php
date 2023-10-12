<?php 
	include 'conn.php';

    if(isset($_GET["del"])){
	    @$id=intval($_GET['id']);
	    @$name=$_GET["name"];
	    $query=$conn->prepare("DELETE FROM images WHERE id=?");
	    @unlink('/home/u781260265/domains/mariakapsiak.pl/public_html/sesje/zdj/'.$name);
	    header('Location: ' . $_SERVER['HTTP_REFERER']);
	    $query->execute(array($id));
	    $x=$querry->fetch(PDO::FETCH_OBJ);
	   // header("Refresh:2");
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
        <link rel="stylesheet" href="style_logowanie.css">

    </head>
    <body>
            <small>Zalogowany użytkownik: </small>
            <br>
            <?php
                session_start();
                print $_SESSION['username'];
            ?>
            <br>
            <a href = "logout.php"> WYLOGUJ</a>

        <br><br>
 
            <form method="POST" action="upload.php" enctype="multipart/form-data">
                <?php
                    if (isset($_GET['error'])) {
                        echo "<p style='color: red'>";
                            echo htmlspecialchars($_GET['error']);
                        echo "</p>";
                    }
                ?>
                Wybierz zdjęcia do przesłania<br><br>
                <input type="file" id="getFile" name="images[]" multiple><br><br>
                <button type="submit" name="upload">Wyślij</button>
            </form>
        
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



