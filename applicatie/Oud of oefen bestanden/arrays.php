<?php
$namen = [
    'Henk',
    'Piet',
    'Jan'
];
// for ($i = 0; $i < count($namen); $i++) {
//     echo ($namen[$i]);
//     echo ('<br>');
// }

$klassen =[
    ["jan", "Geert"],
    ["Kees", "Truus"],
    ["henk", "Piet"],
    ["lukas", "rens", "job"]
];

foreach($klassen as $namen)
{
    foreach($namen as $naam){
    echo($naam);
   echo('<br>');
    }
}
echo('<br>');

$leeftijd =[
    "jan" => 18,
    "Geert" => 44,
    "Kees" => 21,
    "Truus" => 14,
    "henk" => 24,
    "Piet" => 5,
    "lukas" => 19,
    "rens" => 30,
    "job" => 18
];

foreach($leeftijd as $naam => $waarde)
{
    echo($naam);
    echo(" is ");
    echo($waarde);
    echo('<br>');
}
?>