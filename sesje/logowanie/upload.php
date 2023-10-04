<?php
session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
if (!isset($_SESSION['loggedin']))
{
header('Location: index.php');
exit();
}
include 'conn.php';


if (isset($_POST['upload'])) {
    // połączenie z db
    include 'conn.php';
    
    $images = $_FILES['images'];
    
    // licznik zdjęć
    $num_of_imgs = count($images['name']);
    
    for($i = 0; $i < $num_of_imgs; $i++) {
        // info na temat zdjęć
        $image_name = $images['name'][$i];
        $tmp_name = $images['tmp_name'][$i];
        $error = $images['error'][$i];
        
        if($error === 0) {
            // info o rozszerzeniach plików
            $img_ex = pathinfo($image_name, PATHINFO_EXTENSION);
            
            // konwersja literek rozszerzenia na małe
            $img_ex_lc = strtolower($img_ex);
            
            // lista dopuszczalnych rozszerzeń plików, a dokładnie zdjęć
            $allowed_ex = array('jpg', 'jpeg', 'png', 'gif', 'svg', 'raw', 'heif');
            
            // sprawdzenie czy wgrane zdjęcie ma dopuszczalne rozszerzenie pliku
            if(in_array($img_ex_lc, $allowed_ex)) {
                // zmiana nazwy pliku na unikalny i początek "zdj-"
                $new_img_name = uniqid('zdj-').'.'.$img_ex_lc;
                // ścieżka do katalogu
                $img_upload_path = '/home/u781260265/domains/mariakapsiak.pl/public_html/sesje/zdj/'.$new_img_name;
                // wpisanie zdjęcia do bazy danych
                $sql = "INSERT INTO images (img_name) VALUES (?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$new_img_name]);
                // przeniesienie zdjęcia w docelowe miejsce
                move_uploaded_file($tmp_name, $img_upload_path);
                // przekierowanie na stronę z wynikami
                header("Location: index.php");

                
            }else{
                // Wiadomość z błędem oraz przekierowanie do strony wyboru pliku
                $error_message = "☹ Nie można przesłać zdjęcia z takim rozszerzeniem!︎";
                header("Location: index.php?error=$error_message");
            }
            
            
        }else{
            // Wiadomość z błędem oraz przekierowanie do strony wyboru pliku
            $error_message = "☹ Błąd podczas wysyłania pliku!︎";
            header("Location: index.php?error=$error_message");
        }
    }
}








?>