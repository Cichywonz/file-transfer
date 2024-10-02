
<?php
 include("database.php");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="kolorki.css">
    <title>System DO</title>
</head>
<body>
    
       <a href="login.php"> <button >Zaloguj się</button> </a>
            <form action ="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" >
                <ul></br>
                    <li>imie: <input type="text" name="imie"></li></br>
                    <li>nazwisko: <input type="text" name="nazwisko"></li></br>
                    <li>telefon: <input type="tel" name="telefon" placeholder="+48123456789"></li></br>
                    <li>adres e-mail: <input type="email" name="email" placeholder="example@gmail.com"></li></br>
                <ul>
                <input type="submit" name="register" value="Zarejestruj się">
            </form>
            

</body>
</html>
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){

    $imie = filter_input(INPUT_POST, "imie", FILTER_SANITIZE_SPECIAL_CHARS);
    $nazwisko = filter_input(INPUT_POST, "nazwisko", FILTER_SANITIZE_SPECIAL_CHARS);
    $telefon = $_POST['telefon'];
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

    if(empty($imie))
        echo "Podaj imie";
    elseif(empty($nazwisko))
        echo "Podaj nazwisko";
    elseif(empty($telefon))
        echo "Podaj numer telefonu";
    else{
        $sql = "INSERT INTO osoby(imie, nazwisko, nr_telefonu, adres_email)
                VALUES  ('$imie', '$nazwisko', '$telefon', '$email')";
        mysqli_query($conn, $sql);
        echo "Zarejestrowany";        
    }

}

mysqli_close($conn);
?>