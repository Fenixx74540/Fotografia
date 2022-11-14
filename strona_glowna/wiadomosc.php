<?php
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $term = $_POST['term'];
    $message = $_POST['message'];

    if(!empty($email) && !empty($message)){ //jeśli email i wiadomość jest posta
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){ //jeśli e-mail jest niepoprawny
            $receiver = "kontakt@photographerolaa.pl"; //odbiorca wiadomości mailowej
            $subject = "Od: $name <$email>"; // wyświetlenie odbiorcy
            //sklejenie wysłanych danych
            $body = "Imię: $name\nEmail: $email\nTelefon: $phone\nStrona: $term\n\nWiadomość: $message\n\nPozdrawiam,\n$name";
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