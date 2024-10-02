<?php
use Twilio\Rest\Client;
require __DIR__ . "/vendor/autoload.php";

function sendSMS($to, $password, $imie, $nazwisko, $telefon)
{
    $sid = ''; 
    $token = ''; 
    $twilio_number = '';

    $client = new Client($sid, $token);

    $client->messages->create($to,
        array(
            'from' => $twilio_number,
            'body' => "Witaj".$imie .$nazwisko."Otrzymałeś nowy plik od użytkownika o numerze telefonu: " . $telefon."Hasło do folderu ".$password
        )
    );
    echo "SMS został wysłany do odbiorcy: " . htmlspecialchars($to) . ".<br>";
}
?>