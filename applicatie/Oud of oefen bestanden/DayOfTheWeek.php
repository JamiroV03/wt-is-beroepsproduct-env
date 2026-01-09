<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
$dayOfWeek = date('l'); 

switch ($dayOfWeek) {
    case 'Monday':
    case 'Tuesday':
        echo 'Nee, nog lang niet.';
        break;
    case 'Wednesday':
    case 'Thursday':
        echo 'Nog even wachten.';
        break;
    case 'Friday':
        echo 'Bijna!';
        break;
    case 'Saturday':
    case 'Sunday':
        echo 'Jaaaaa, het is weekend!';
        break;
    default:
        echo 'Ongeldige dag';
}
?>
</body>
</html>