<?php 
    include "logowanie/conn.php";
	$sql  = "SELECT img_name FROM images ORDER BY id DESC";

	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$images = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maria Kapsiak Galeria</title>
    <link href="rekwizyty/favicon.ico" rel="icon" type="image/x-icon" />
    <link rel="stylesheet" href="style_galeria.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    
</head>
<body>
    <div class="scroll-up-btn">
        <i class="fas fa-angle-up"></i>
    </div>
    <nav class="navbar">
        <div class="max-width">
            <div class="logo"><a href="index.html#home">Portfol<span>lio.</span></a></div>
            <ul class="menu">
                <li><a href="index.html#home" class="menu-btn">Strona główna</a></li>
                <li><a href="index.html#about" class="menu-btn">O mnie</a></li>
                <li><a href="index.html#services" class="menu-btn">Usługi</a></li>
                <li><a href="index.html#skills" class="menu-btn">Umiejętności</a></li>
                <li><a href="galeria.html" class="menu-btn">Galeria</a></li>
                <li><a href="index.html#contact" class="menu-btn">Kontakt</a></li>
            </ul>
        </div>
    </nav>
    
    
    <?php if ($stmt->rowCount() > 0) { ?>
        <div class="wrapper">
        	<div class="gallery">
        		<?php foreach ($images as $image) { ?>
        		   <div class="image"><span><img src="/sesje/zdj/<?=$image['img_name']?>"></span></div>
        		<?php } ?>
        	</div>
    	</div>
    <?php } ?>
    

    <div class="preview-box">
        <div class="details">
            <span class="title">Zdjęcie <p class="current-img"></p> z <p class="total-img"></p></span>
            <span class="icon fas fa-times"></span>
        </div>
        <div class="image-box">
            <div class="slide prev">
                <i class="fas fa-angle-left"></i>
            </div>
            <div class="slide next">
                <i class="fas fa-angle-right"></i>
            </div>
            <img src="" alt="">
        </div>
    </div>
    <div class="shadow"></div>
    <script src="script_galeria.js"></script>
    
</body>
</html>