<?php
require_once 'db_connectie.php';

// ------- functies
function genresAsSelect()
{
    $db = maakVerbinding();
    $sql = 'select genrenaam
            from genre
            order by genrenaam';

    $data = $db->query($sql);

    $html = '<select id="genre" name="genre">';

    foreach ($data as $rij) {
        $genrenaam = $rij['genrenaam'];
        $html .= "<option value=\"$genrenaam\">$genrenaam</option>";
    }

    $html .= '</select>';
    return $html;
}

// ------- logica
if (isset($_GET['genre'])) {
    $genre = $_GET['genre'];
} else {
    $genre = 'pop';
}

// verbinding maken met db
$db = maakVerbinding();

// Query maken
$sql = 'select stuknr, titel, genrenaam, n.omschrijving, c.naam
        from stuk s
        left outer join niveau n on s.niveaucode = n.niveaucode
        inner join componist c on s.componistId = c.componistId
        where genrenaam = :genre';

// Gegevens ophalen
$data = $db->prepare($sql);

$data_array = [
    ':genre' => $genre
];

$data->execute($data_array);

// Gegevens verwerken
$muziekstukken = '<table>';
foreach ($data as $rij) {
    // Haal alle kolomen op
    $stuknr = $rij['stuknr'];
    $titel = $rij['titel'];
    $genrenaam = $rij['genrenaam'];
    $omschrijving = $rij['omschrijving'];
    $naam = $rij['naam'];

    $muziekstukken .= "<tr><td>$stuknr</td><td>$titel</td><td>$genrenaam</td><td>$omschrijving</td></tr>";
}
$muziekstukken .= '<table>';

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Muziekstukken</title>
</head>

<body>
    <label for="genre">Filter:</label>
    <form action="" method="get">
        <?= genresAsSelect() ?>

        <input type="submit" value="filter" />
    </form>


    <h1>Muziekstukken</h1>
    <?= $muziekstukken ?>
</body>

</html>