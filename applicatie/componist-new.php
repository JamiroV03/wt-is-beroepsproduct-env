<?php
require_once 'db_connectie.php';

$componistId = "";
$naam = "";
$geboortedatum = "";
$schoolId = "";

if (isset($_POST['opslaan']) && !empty($_POST['opslaan'])) {

    //Uitlezen opgestuurde waarden
    $componistId   = trim(strip_tags($_POST['componistId']));
    $naam          = trim(strip_tags($_POST['naam']));
    $geboortedatum = trim(strip_tags($_POST['geboortedatum']));
    $schoolId      = trim(strip_tags($_POST['schoolId']));

    //Controleren van de waardes
    $fouten = [];
    //ComponistId
    if (empty($componistId)) {
        $fouten[] = "Componist id is verplicht.";
    } else if (!is_numeric($componistId)) {
        $fouten[] = "Componist id moet een positief getal zijn.";
    }

    //Naam
    if (empty($naam)) {
        $fouten[] = "Naam is verplicht.";
    }

    //Geboortedatum
    if (empty($geboortedatum)) {
        $geboortedatum = null;
    }

    //SchoolId
    if (empty($schoolId)) {
        $schoolId = null;
    }

    //Check op fouten
    if (count($fouten) == 0) {

        $db = maakVerbinding();
        $sql = 'insert into Componist (componistId, naam, geboortedatum, schoolId)
        values(:componistId, :naam, :geboortedatum, :schoolId)';

        $data = $db->prepare($sql);
        $data_array = [
            ':componistId' => $componistId,
            ':naam' => $naam,
            ':geboortedatum' => $geboortedatum,
            ':schoolId' => $schoolId,
        ];
        $succes = $data->execute($data_array);

        if ($succes) {
            $melding = 'De gegevens staan in de database';
            //leegmaken velden
            $componistId = "";
            $naam = "";
            $geboortedatum = "";
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
    <title>Componinst - nieuw</title>
    <link href="css/normalize.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <form action="componist-new.php" method="post">
        <label for="componistId">componistId</label>
        <input type="text" id="componistId" name="componistId" value="<?= $componistId ?>"><br>

        <label for="naam">naam</label>
        <input type="text" id="naam" name="naam" value="<?= $naam ?>"><br>

        <label for="geboortedatum">geboortedatum</label>
        <input type="date" id="geboortedatum" name="geboortedatum" value="<?= $geboortedatum ?>"><br>

        <label for="schoolId">schoolId</label>
        <input type="text" id="schoolId" name="schoolId" value="<?= $schoolId ?>"><br>

        <input type="reset" id="reset" name="reset" value="wissen">
        <input type="submit" id="opslaan" name="opslaan" value="opslaan">
    </form>

    <?= $melding ?>
</body>

</html>