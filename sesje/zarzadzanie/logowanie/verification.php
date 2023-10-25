<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username='$user'"); // wiersza, w którym login=login z formularza
    $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
        
        
    if(!$rekord) //Jeśli brak, to nie ma użytkownika o podanym loginie
    {
        mysqli_close($conn); // zamknięcie połączenia z BD
        echo "Błędne dane logowania!"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
        echo '<a href = "login.php"> Spróbuj ponownie';
        exit();
    } else { // jeśli $rekord istnieje
        if($rekord['password']==$pass) // czy hasło zgadza się z BD
        {
            //echo "Logowanie Ok. User: {$rekord['username']}. Hasło: {$rekord['password']}";
            session_start();
             $_SESSION ['loggedin'] = true;
             $_SESSION['username'] = $rekord['username'];
             header('Location:/sesje/zarzadzanie/index.php');
             exit();
        }
        else
        {
            mysqli_close($conn);
            echo '<h1 style="color:red;">Błędne dane!</h1><br>';
            echo '<a href = "login.php"> Spróbuj ponownie';
        }
    }
    ?>
</BODY>
</HTML>