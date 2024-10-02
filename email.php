<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
require __DIR__ . '/vendor/autoload.php';

function sendEmailWithAttachment($recipientEmail, $senderPhone, $zipFilePath, $imie, $nazwisko) 
{
    $mail = new PHPMailer(true);

    try 
    {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'grzesiek12345678902@gmail.com'; 
        $mail->Password   = 'jgxmucamcbyjqfcg'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('grzesiek12345678902@gmail.com', 'Blachtex');
        $mail->addAddress($recipientEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Nowy plik przesłany';
        $mail->Body    = "Witaj," .$imie. ' ' .$nazwisko. "<br><br>Otrzymałeś nowy plik od użytkownika o numerze telefonu: " .$senderPhone. "<br> Plik:"  .htmlspecialchars(basename($zipFilePath)).
            "TANIE BLACHY BLACHTEX Sp. z.o.o. </br>
            Adres siezdziby Firmy:  </br>
            Stobierna 836B, 36-002 Jasionka </br>
            NIP: 5170425072 </br>
            REGION:52190782 <br>
            KRS: 0000963898 <br>
            Kapitał zakładowy 5 000 000 000zł<br>";

        $mail->addAttachment($zipFilePath);

        $mail->send();
        echo "E-mail został wysłany do odbiorcy: " . htmlspecialchars($recipientEmail) . ".<br>";
    } 
    catch (Exception $e) 
    {
        echo "Wystąpił problem podczas wysyłania e-maila: {$mail->ErrorInfo}<br>";
    }
}
?>