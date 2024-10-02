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
<div class = "container">
    <div class = "mid">
    <h1>Panel wysyłanai plików<h2>
    <h5>Wprowadź dane osoby, której chcesz wysłać plik</h5>
        <form action="stronka.php" method="post" enctype="multipart/form-data">
            <ul>
                <li>Imie: <input type="text" name="imie" ></li>
                <li>Nazwisko: <input type="text" name="nazwisko" ></li>
                <li>telefon odbiorcy pliku: <input type="tel" name="to" placeholder="+48123456789" ></li></br>
                <li>adres e-mail odbiorcy pliku: <input type="email" name="email_odbiorcy" placeholder="example@gmail.com" ></li>
            </ul>
            Wybierz pliki: <input type="file" multipe name="fileToUpload[]" required></br>
            <input type="submit" value="Prześlij plik" name="submit">
        </form>
    </div>
</div>
            

</body>
</html>
<?php

    session_start();
    if (isset($_SESSION['telefon'])) {
        $telefon = $_SESSION['telefon'];
        $email = $_SESSION['email'];
        echo "Twój numer telefonu to: " . htmlspecialchars($telefon) . "<br>";
        echo "Twój adres email to: " . htmlspecialchars($email) . "<br>";
    } else {
        echo "Nie jesteś zalogowany.<br>";
        exit;
    }

    $uploadOk = 1;
    $to = isset($_POST['to']) ? $_POST['to'] : '';
    $imie = filter_input(INPUT_POST, "imie", FILTER_SANITIZE_SPECIAL_CHARS);
    $nazwisko = filter_input(INPUT_POST, "nazwisko", FILTER_SANITIZE_SPECIAL_CHARS);
    $email_odbiorcy = filter_input(INPUT_POST, "email_odbiorcy", FILTER_VALIDATE_EMAIL);

    if (!$to) {
        echo "Numer telefonu jest nieprawidłowy.<br>";
        $uploadOk = 0;
    } 

    if (!$email_odbiorcy) {
        echo "Adres e-mail jest nieprawidłowy.<br>";
        $uploadOk = 0;
    }

    $password = rand(0,9);
    $_SESSION['password'] = $password;
    if(isset($_POST["submit"])&& is_array($_FILES["fileToUpload"]["name"]))
    {
    
    $zip_filename = "uploads/".$to.".zip";   
    $user_zip = "uploads/".$telefon.".zip";    
    require 'zip.php';
    saverZip($password, $zip_filename ); 
    if($telefon != '+48793535431')
    generateDownloadLinks($user_zip);
    else
    generateDownloadAllLinks($user_zip);


    require 'email.php';
    sendEmailWithAttachment($email_odbiorcy, $telefon, $zip_filename, $imie, $nazwisko );

    require 'sms.php';
    sendSMS($to,$password,$imie, $nazwisko, $telefon);

    }
    else 
        echo "Wystąpił błąd podczas tworzenia pliku ZIP.<br>";
mysqli_close($conn);
?>