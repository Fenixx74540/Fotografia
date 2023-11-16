<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style_verification.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
</HEAD>
<BODY>
    <?php
    $user = htmlentities ($_POST['user'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $user
    $pass = htmlentities ($_POST['pass'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $pass
     
    $dbhost="localhost"; 
    $dbuser="u781260265_maria"; 
    $dbpassword="zaq1@WSX"; 
    $dbname="u781260265_fotografia";
    $conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname); 

    if(!$conn) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD
    mysqli_query($conn, "SET NAMES 'utf8'"); // ustawienie polskich znaków
    $query = "SELECT * FROM admin WHERE username='$user'";
    $result = mysqli_query($conn, $query); // wiersza, w którym login=login z formularza
    $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
        
        
    if(!$rekord) {//Jeśli brak, to nie ma użytkownika o podanym loginie
        mysqli_close($conn); // zamknięcie połączenia z BD
        echo '<div class="wrapper">';
            echo '<i class="fa-solid fa-triangle-exclamation"></i><br>';
            echo '<h1>Błędne dane!</h1><br>';
            echo '<a href = "login.html">Spróbuj ponownie';
        echo '</div>';
        exit();
    } else { // jeśli $rekord istnieje
        $hashedPassword = $rekord['password'];
        //if($rekord['password']==$pass) {// czy hasło zgadza się z BD
        if(password_verify($pass, $hashedPassword)){
            session_start();
             $_SESSION ['loggedin'] = true;
             $_SESSION['username'] = $rekord['username'];
             header('Location:/sesje/zarzadzanie/index.php');
             exit();
        } else {
            mysqli_close($conn);
            echo '<div class="wrapper">';
                echo '<i class="fa-solid fa-triangle-exclamation"></i><br>';
                echo '<h1>Błędne dane!</h1><br>';
                echo '<a href = "login.html">Spróbuj ponownie';
            echo '</div>';
            exit();
        }
    }
    ?>
</BODY>
</HTML>