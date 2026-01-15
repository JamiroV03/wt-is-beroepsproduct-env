<?php
require_once '../includes/db_connectie.php';
require_once '../includes/header.php';

if (!isset($_SESSION['ingelogd']) || !$_SESSION['ingelogd']) {
    die('Je moet ingelogd zijn om te bestellen.');
}

if (empty($_SESSION['winkelmandje'])) {
    die('Je winkelmandje is leeg.');
}

$adres = trim($_POST['adres'] ?? '');
if ($adres === '') {
    die('Adres is verplicht.');
}

$db = maakVerbinding();

$sqlMedewerker = "
SELECT TOP 1 username
FROM [User]
WHERE role = 'medewerker'
ORDER BY username
";
$medewerker = $db->query($sqlMedewerker)->fetchColumn();

$sqlOrder = "
INSERT INTO Pizza_Order (
    client_username,
    client_name,
    personnel_username,
    datetime,
    status,
    address
)
VALUES (
    :client_username,
    :client_name,
    :personnel_username,
    GETDATE(),
    0,
    :address
)
";

$stmt = $db->prepare($sqlOrder);
$stmt->execute([
    ':client_username'    => $_SESSION['username'],
    ':client_name'        => $_SESSION['username'],
    ':personnel_username' => $medewerker,
    ':address'            => $adres
]);

$orderId = $db->lastInsertId();

$sqlProduct = "
INSERT INTO Pizza_Order_Product (
    order_id,
    product_name,
    quantity
)
VALUES (
    :order_id,
    :product_name,
    :quantity
)
";

$stmtProduct = $db->prepare($sqlProduct);

foreach ($_SESSION['winkelmandje'] as $product => $aantal) {
    $aantal = (int)$aantal;

    if ($aantal < 1 || $aantal > 5) {
        continue; // negeer ongeldige waarden
    }

    $stmtProduct->execute([
        ':order_id'     => $orderId,
        ':product_name' => $product,
        ':quantity'     => $aantal
    ]);
}


unset($_SESSION['winkelmandje']);
?>

<h1>Bestelling geplaatst 🎉</h1>
<p>Je bestelling is succesvol opgeslagen.</p>
<p><a href="profiel.php">Bekijk je bestellingen</a></p>

<?php require_once '../includes/footer.php'; ?>
