<?php 
	include 'conn.php';

	$sql  = "SELECT img_name FROM images ORDER BY id DESC";

	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$images = $stmt->fetchAll();
 ?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="vewport" content="width=device-width, initial-scale=1.0">
  
        <style>
            body {
                display: flex;
                align-items: center;
                flex-direction: column;
                font-family: 'Roboto', sans-serif;
            }
            .gallery img{
                width: 1270px;
            }
        </style>
    </head>
    <body>
        <small>Zalogowany użytkownik: </small>
        <!-- ---------------------------------- -->
        <?php
            session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
            print $_SESSION['username'];
        ?>

        <!-- ---------------------------------- -->
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
                <!--<button style="display:block;width:120px; height:30px;" onclick="document.getElementById('getFile').click()">Wybierz zdjęcia</button>-->
                <input type="file" id="getFile" name="images[]" multiple><br><br>
                <button type="submit" name="upload">Wyślij</button>
            </form>
        
        
        <?php if ($stmt->rowCount() > 0) { ?>
        	<div class="gallery">
        		<h4>All Images</h4>
        		<?php foreach ($images as $image) { ?>
        		   <img src="/sesje/zdj/<?=$image['img_name']?>">
        		<?php } ?>
        	</div>
	    <?php } ?>


                
        <br><br>
        <a href = "logout.php"> WYLOGUJ </a>
    </body>
</html>



