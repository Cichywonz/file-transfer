
<?php
 session_start();
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loguj'])) {
    $telefon = $_POST['telefon'];
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

    if ($email && $telefon) {
        $sql = "SELECT adres_email, nr_telefonu FROM osoby WHERE adres_email = ? AND nr_telefonu = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ss', $email, $telefon);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $_SESSION['telefon'] = $telefon;
                $_SESSION['email'] = $email;
                header("Location: stronka.php");
                exit;
            } else {
                echo "Nieprawidłowy email lub telefon.";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Wystąpił błąd podczas przygotowywania zapytania.";
        }
    } else {
        echo "Nieprawidłowy email lub telefon.";
    }

    mysqli_close($conn);
}
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
<div class="container">
    <div class="mid">
        <h1>Logowanie</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <ul>
                <li>Email: <input type="email" name="email" placeholder="example@gmail.com" required></li>
                <li>Nr telefonu: <input type="tel" name="telefon" placeholder="+48123456789" required></li>
            </ul>
            <input type="submit" value="Zaloguj" name="loguj">
        </form>
    </div>
</div>
</body>
</html>