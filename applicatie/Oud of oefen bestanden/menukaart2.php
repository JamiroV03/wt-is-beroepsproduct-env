<?php

function gerecht($naam, $prijs) {
    $prijsAlsTekst = number_format($prijs, 2, ',', '.');
    return "<tr><td>$naam</td><td>&euro; $prijsAlsTekst</td></tr>";
}

function menuOnderdeel($titel, $gerechten) {
    $onderdeel = "<h2>$titel</h2>";
    $onderdeel .= '<table>';
    foreach($gerechten as $consumptie => $prijs) {
        $onderdeel .= gerecht($consumptie, $prijs);
    }
    $onderdeel .= '</table>';
    return $onderdeel;
}

function menuVolledig( $menu ) {
    $menukaart = '';
    foreach($menu as $naam => $consumpties) {
        $menukaart .= menuOnderdeel($naam, $consumpties);
    }
    return $menukaart;
}

// Logica van de pagina
$restaurantMenu = [
    'Eten' => ['Pannenkoek' => 18.70, 'Hamburger' => 5.50, 'Broodje Gezond' => 4.00],
    'Drinken' => ['Cola' => 2.00, 'Spa Rood' => 5.50, 'Bier' => 2.30, 'Witte wijn' => 3.20, 'Rode wijn' => 3.20],
    'Toetjes' => ['ijs' => 1.20, 'Hemelse modder' => 7, 'Bakje pepernoten' => 4.31]
];

if(isset($_GET['menuonderdeel'])) {
    $keuze = $_GET['menuonderdeel'];
    $menuInPagina = menuOnderdeel($keuze, $restaurantMenu[$keuze] ); 
} else {
    $menuInPagina = menuVolledig($restaurantMenu);
}

?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Restaurantmenu</title>
    <style>
        td:first-child{
            width: 8em;
        }
        td:nth-child(2) {
            font-style: italic;
            text-align: right;
            width: 4em;
        }
    </style>
</head>
<body>
    <h1>Menu</h1>
    <?= $menuInPagina ?>
</body>
</html>