<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style_verification.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
</head>
<body>
<?php

include('/home/u781260265/domains/mariakapsiak.pl/public_html/sesje/zarzadzanie/baza_danych/conn.php');

$new_username = htmlentities ($_POST['username'], ENT_QUOTES, "UTF-8");
$new_password1 = htmlentities ($_POST['password1'], ENT_QUOTES, "UTF-8");
$new_password2 =htmlentities ($_POST['password2'], ENT_QUOTES, "UTF-8");

$hashed_password = password_hash($new_password1, PASSWORD_DEFAULT);

if ($new_password1 != $new_password2) {
    echo '<div class="wrapper">';
    echo '<i class="fa-solid fa-triangle-exclamation"></i><br>';
    echo '<h1>Błędne dane!</h1><br>';
    echo "Hasło nie pasują do siebie<br><br>";
    echo '<a href = "register.php">Spróbuj ponownie';
    echo '</div>';
    exit();
}

preg_match('/[!@#$%^&*()]+/', $new_password1, $matches);
if (sizeof($matches) == 0) {
    echo '<div class="wrapper">';
    echo '<i class="fa-solid fa-triangle-exclamation"></i><br>';
    echo '<h1>Błędne dane!</h1><br>';
    echo "Hasło musi mieć przynajmniej jeden znak specjalny !@#$%^&*()<br><br>";
    echo '<a href = "register.php">Spróbuj ponownie';
    echo '</div>';
    exit();
}

if (strlen($new_username) <= 0) {
    echo '<div class="wrapper">';
    echo '<i class="fa-solid fa-triangle-exclamation"></i><br>';
    echo '<h1>Błędne dane!</h1><br>';
    echo "Nazwa użytkownika nie może być pusta <br><br>";
    echo '<a href = "register.php">Spróbuj ponownie';
    echo '</div>';
    exit();
}

if (strlen($new_password1) <= 7) {
    echo '<div class="wrapper">';
    echo '<i class="fa-solid fa-triangle-exclamation"></i><br>';
    echo '<h1>Błędne dane!</h1><br>';
    echo "Hasło musi mieć przynajmniej 8 znaków <br><br>";
    echo '<a href = "register.php">Spróbuj ponownie';
    echo '</div>';
    exit();
}

//sprawdzenie czy nie ma takiego użytkownika w systmeie
$query="SELECT username FROM admin WHERE username = '$new_username'";
$query_res =   $conn->query($query);
$count= count($query_res->fetchAll());
if($count > 0){
    echo '<div class="wrapper">';
    echo '<i class="fa-solid fa-triangle-exclamation"></i><br>';
    echo '<h1>Błędne dane!</h1><br>';
    echo "Jest już użytkownik z nazwą: " . $new_username;
    echo '<br><br><a href = "register.php">Spróbuj ponownie';
    echo '</div>';
    exit();
}


//wpisanie użytkowniak do bazy danych
$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?,?)");
$stmt->bindParam(1, $new_username);
$stmt->bindParam(2, $hashed_password);
$result = $stmt->execute();

if ($result) {
    echo "Jest OK";
    header("Location: login.html");
} else {
    mysqli_close($conn);
    echo '<div class="wrapper">';
    echo '<i class="fa-solid fa-triangle-exclamation"></i><br><br>';
    echo '<h1>Błędne dane!</h1><br>';
    echo '<a href = "register.php">Spróbuj ponownie';
    echo '</div>';
    exit();
    
}

?>


</body>
</html>


















