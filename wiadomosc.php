<?php
    $name = $_POST['imie'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $strona = $_POST['strona'];
    $wiadomosc = $_POST['wiadomosc'];

    if(!empty($email) && !empty($wiadomosc)){ //jeśli email i wiadomość jest posta
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){ //jeśli e-mail jest niepoprawny
            $receiver = "mateuszlassa@gmial.com"; //odbiorca wiadomości mailowej
            $subject = "Od: $imie <$email>"; // wyświetlenie odbiorcy
            //sklejenie wysłanych danych
            $body = "Imię: $imie\nEmail: $email\nTelefon: $telefon\nStrona: $strona\n\nWiadomość: $wiadomosc\n\nPozdrawiam,\n$imie";
            $sender = "Od: $email"; // osoba wysyłająca maila
            if(mail($receiver, $subject, $body, $sender)){
                echo "Wiadomość została pomyślnie wysłana";
            }else{
                echo "Bład podczas wysyłania wiadomości";
            }
        }else{
            echo "Podaj poprawny e-mail";
        }
    }else{
        echo "Wpisz dane do pola wiadomość i email";
    }
?>