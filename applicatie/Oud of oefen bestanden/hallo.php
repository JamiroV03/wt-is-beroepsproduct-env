<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voorbeeld</title>
</head>
<body>
    <h1>Een zeer goede dag</h1>
    <?php
//     if(isset($_GET['voornaam'])){
//         $voornaam = $_GET['voornaam'];
//     } else{
//         $voornaam = "Onbekend";
//     }
//     if(isset($_GET['achternaam'])){
//         $achternaam = $_GET['achternaam'];
//     } else{
//         $achternaam = "Onbekend2";
//     }
//     $naam = $voornaam. ' ' . $achternaam;
//    echo($naam);



if(isset($_GET['datum'])){
   $datum = $_GET['datum'];
}else{
    $datum = date_create('now');
}

if(isset($_GET['EindDatum'])){
    $EindDatum = $_GET['EindDatum'];
}else{
    $EindDatum = date_create('5-12-2023');
}

   $verschil = date_diff($datum, $EindDatum);
echo $verschil->format('%a dagen, %m maanden, %h uur, %s seconden tot eind datum');
    ?>
</body>
</html>