<?php
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $phone = htmlspecialchars($_POST['phone']);
  $term = htmlspecialchars($_POST['term']);
  $message = htmlspecialchars($_POST['message']);

  if(!empty($email) && !empty($message)){ //jeśli email i wiadomość jest posta
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){ //jeśli e-mail jest niepoprawny
      $receiver = "kontakt@mariakapsiak.pl"; //odbiorca wiadomości mailowej
      $subject = "Od: $name <$email>"; // wyświetlenie odbiorcy w tytule maila
      //sklejenie wysyłanych danych
      $body = "Imię: $name\nEmail: $email\nNr. kontaktowy: $phone\nTermin: $term\n\nNotka:\n$message\n\nPozdrawiam,\n$name";
      //dodanie polskich znaków w formacie UTF-8
      $pl_body = iconv('UTF-8', 'UTF-8//IGNORE', $body);
      $sender = "Od: $email";
      if(mail($receiver, $subject, $pl_body, $sender)){
         echo "Wiadomość została wysłana";
      }else{
         echo "Przepraszamy, mamy problem z wysłaniem wiadomości";
      }
    }else{
      echo "Podaj poprawny adres E-mail";
    }
  }else{
    echo "Pola E-mail oraz notka są wymagane";
  }
?>
