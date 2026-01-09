<?php
    require_once 'db_connectie.php';

    $melding = '';  // nog niks te melden 
    $fouten[] = '';
    if(isset($_POST['inloggen'])) {
        // 1. lees gegevens
        $naam        = $_POST['gebruikersnaam'];
        $wachtwoord  = $_POST['wachtwoord'];
       
        // 2. check gegevens
        // Inhoud checken dat mag je zelf doen
        if (empty($naam)) {
            $fouten[] = "naam is verplicht.";
        } 
        if (empty($wachtwoord)) {
            $fouten[] = "wachtwoord is verplicht.";
        } 
        $melding = '<ul>';
        foreach ($fouten as $fout) {
            $melding .= "<li>$fout</li>";
        }
        $melding .= '</ul>';
        // 3. Ophalen van de hash uit de database
        // database
        $db = maakVerbinding();
        // Select query (prepared statement)
        $sql = 'SELECT passwordhash
                FROM Gebruikers
                WHERE naam = :naam';
        $query = $db->prepare($sql);
    
        $data_array = [
            ':naam' => $naam
        ];
        // get data from daatabase
        $query->execute($data_array);
    
        if ($rij = $query->fetch()) {
            //gebruiker gevonden
            $passwordhash = $rij['passwordhash'];
    
            //wachtwoord checken
            if (password_verify($wachtwoord, $passwordhash)) {
                session_start();
                // header('location: index.php');
                $_SESSION['gebruiker'] = $naam;
                $melding = 'Gebruker is ingelogd';
            } else {
                $melding = 'fout: incorrecte inloggegevens!!';
            }
        } else {
            $melding = 'Incorrecte inloggegevens';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inloggen</title>
</head>
<body>
<form method="post" action="inloggen.php">
<table>
    <tr>
        <td><label for="gebruikersnaam">gebruikersnaam</label></td>
        <td><input type="text" id="gebruikersnaam" name="gebruikersnaam"></td>
    </tr>
    <tr>
        <td><label for="wachtwoord">wachtwoord</label></td>
        <td><input type="password" id="wachtwoord" name="wachtwoord"></td>
    </tr>
    <tr>
        <td> </td>
        <td><input type="submit" name="inloggen" value="inloggen"></td><br>
 
    </tr>
</table>
</form>
<?=$melding?><br>
<a href="logout.php">Log uit</a>
</body>
</html>