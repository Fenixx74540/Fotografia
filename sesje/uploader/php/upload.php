<?php
    $file_name = $_FILES['file']['name']; //pobranie nazwy pliku
    $tmp_name = $_FILES['file']['tmp_name']; //pobranie tymczasowej nazwy pliku
    $File_up_name = time().$file_name; //dodanie aktualnego czasu do nazwy pliku
    move_uploaded_file($tmp_name, "files/".$File_up_name); //przeniesienie pliku
    
?>