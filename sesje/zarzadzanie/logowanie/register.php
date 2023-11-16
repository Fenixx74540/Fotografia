<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rejestrowanie</title>
    <link rel="stylesheet" href="style_logowanie.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
</head>
<body>
    <div class="wrapper">
        <form method="post" action="add_user.php">
            <h1>Rejestrowanie</h1>
            <div class="input-box">
                <input type="text" name="username" size="20" placeholder="Nazwa użytkownika">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box">
                <input type="password" name="password1" size="20" placeholder="Hasło">
                <i class="fa-solid fa-key"></i>
            </div>
             <div class="input-box">
                <input type="password" name="password2" size="20" placeholder="Hasło">
                <i class="fa-solid fa-key"></i>
            </div>
            <input type="submit" value="Zarejestruj" class="btn"/>
            <div class="homepage">
                <a href = "https://mariakapsiak.pl/sesje">Przejdź do strony głównej</a>
            </div>
        </form>
   </div>

    
</body>

</html>