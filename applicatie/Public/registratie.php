<?php
require_once '../includes/header.php';
require_once 'db_connectie.php';

$melding = 'Log in';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Haal gegevens uit het formulier
    $naam = $_POST['naam'];
    $wachtwoord = $_POST['wachtwoord'];

    // Hash het wachtwoord
    $passwordhash = password_hash($wachtwoord, PASSWORD_DEFAULT);

    // Database
    $db = maakVerbinding();

    // Insert query (prepared statement)
    $sql = 'INSERT INTO Gebruikers (naam, passwordhash)
            VALUES (:naam, :passwordhash)';
    $query = $db->prepare($sql);

    // Stuur gegevens naar database
    $data_array = [
        ':naam' => $naam,
        ':passwordhash' => $passwordhash
    ];
    $success = $query->execute($data_array);

    // Controleer resultaten
    if ($success) {
        $melding = 'Gebruiker is geregistreerd.';
    } else {
        $melding = 'Registratie is mislukt.';
    }
}
require_once '../includes/footer.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testsessie</title>
</head>
<body>
<form action="registratie.php" method="post">
    <input type="text" name="naam"><br>
    <input type="password" name="wachtwoord"><br>
    <input type="submit" value="registreer">
</form>
<?= $melding ?>
</body>
</html>
