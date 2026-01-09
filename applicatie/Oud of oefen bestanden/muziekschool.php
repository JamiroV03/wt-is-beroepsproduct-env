<?php
require_once 'db_connectie.php';

$naam = "";
$plaatsnaam = "";
$schoolId = "";

if (isset($_POST['opslaan']) && !empty($_POST['opslaan'])) {

    //Uitlezen opgestuurde waarden
    $naam = trim(strip_tags($_POST['naam']));
    $plaatsnaam = trim(strip_tags($_POST['plaatsnaam']));
    $schoolId = trim(htmlentities($_POST['schoolId']));

    //Controleren van de waardes
    $fouten = [];
    //ComponistId
    if (empty($schoolId)) {
        $fouten[] = "School id is verplicht.";
    } else if (!is_numeric($schoolId)) {
        $fouten[] = "School id moet een positief getal zijn.";
    }

    //Naam
    if (empty($naam)) {
        $fouten[] = "Naam is verplicht.";
    }

    //Geboortedatum
    if (empty($plaatsnaam)) {
        $plaatsnaam = null;
    }

    //SchoolId
    if (empty($schoolId)) {
        $schoolId = null;
    }

    //Check op fouten
    if (count($fouten) == 0) {

        $db = maakVerbinding();
        $sql = 'insert into muziekschool (naam, plaatsnaam, schoolId)
        values(:naam, :plaatsnaam, :schoolId)';

        $data = $db->prepare($sql);
        $data_array = [
            ':naam' => $naam,
            ':plaatsnaam' => $plaatsnaam,
            ':schoolId' => $schoolId
        ];
        $succes = $data->execute($data_array);

        if ($succes) {
            $melding = 'De gegevens staan in de database';
            //leegmaken velden
            $naam = "";
            $plaatsnaam = "";
            $schoolId = "";
        } else {
            $melding = 'Er ging iets mis';
        }
    } else {
        $melding = '<ul>';
        foreach ($fouten as $fout) {
            $melding .= "<li>$fout</li>";
        }
        $melding .= '</ul>';
    }
} else {
    $melding = "U mag het formulier invullen";
}

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>muziekschool</title>
    <link href="css/normalize.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <form action="muziekschool.php" method="post">
        <label for="naam">naam</label>
        <input type="text" id="naam" name="naam" value="<?= $naam ?>"><br>

        <label for="plaatsnaam">plaatsnaam</label>
        <input type="text" id="plaatsnaam" name="plaatsnaam" value="<?= $plaatsnaam ?>"><br>

        <label for="schoolId">schoolId</label>
        <input type="text" id="schoolId" name="schoolId" value="<?= $schoolId ?>"><br>

        <input type="reset" id="reset" name="reset" value="wissen">
        <input type="submit" id="opslaan" name="opslaan" value="opslaan">
    </form>

    <?= $melding ?>
</body>

</html>