<?php
require_once 'db_connectie.php';

// Verbinding maken
$db = maakVerbinding();

// SQL-query
$sql = "
SELECT 
    c.naam AS componistNaam,
    FORMAT(c.geboortedatum, 'dd-MM-yy') AS geboortedatum,
    m.naam AS muziekschoolNaam,
    m.plaatsnaam
FROM Componist AS c
LEFT JOIN muziekschool AS m
    ON c.schoolId = m.schoolid
";

// Query uitvoeren
$data = $db->query($sql);

// Resultaat verwerken
$muziekstukken = '<ul>';
foreach ($data as $rij) {
    $naam = htmlspecialchars($rij['componistNaam']);
    $datum = htmlspecialchars($rij['geboortedatum']);

    $muziekstukken .= "<li>$naam ($datum)</li>";
}
$muziekstukken .= '</ul>';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Muziekstukken</title>
</head>
<body>
    <h1>Muziekstukken</h1>
    <?= $muziekstukken ?>
</body>
</html>
