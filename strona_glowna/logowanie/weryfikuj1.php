<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</HEAD>
<BODY>
    <?php
    //  $user=$_POST['user']; // login z formularza
    //  $pass=$_POST['pass']; // hasło z formularza
     $user = htmlentities ($_POST['user'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $user
     $pass = htmlentities ($_POST['pass'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $pass
     
     $dbhost="localhost"; $dbuser="u781260265_maria"; $dbpassword="zaq1@WSX"; $dbname="u781260265_fotografia";
     $link = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname); // połączenie z BD – wpisać swoje dane
     if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD
     mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
     $result = mysqli_query($link, "SELECT * FROM admin WHERE username='$user'"); // wiersza, w którym login=login z formularza
     $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
     
    if(!$rekord) //Jeśli brak, to nie ma użytkownika o podanym loginie
    {
        mysqli_close($link); // zamknięcie połączenia z BD
        echo "Błędne dane logowania!"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
        echo '<a href = "index.php"> Spróbuj ponownie';
        exit();
    } else { // jeśli $rekord istnieje
        if($rekord['password']==$pass) // czy hasło zgadza się z BD
        {
            //echo "Logowanie Ok. User: {$rekord['username']}. Hasło: {$rekord['password']}";
            session_start();
             $_SESSION ['loggedin'] = true;
             $_SESSION['username'] = $rekord['username'];
             header('Location: index2.php');
             exit();
        }
        else
        {
            mysqli_close($link);
            echo "Błędne dane logowania!"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
            echo '<a href = "index.php"> Spróbuj ponownie';
        }
    }
    ?>
</BODY>
</HTML>