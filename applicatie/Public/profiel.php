<?php
require_once '../includes/db_connectie.php';
require_once '../includes/header.php';

// Alleen ingelogde klanten
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'klant') {
    header('Location: login.php');
    exit;
}

$db = maakVerbinding();
$username = $_SESSION['username'];

// Bestellingen ophalen van deze klant
$stmt = $db->prepare("
    SELECT order_id, datetime, status, address
    FROM Pizza_Order
    WHERE client_username = ?
    ORDER BY datetime DESC
");
$stmt->execute([$username]);
$bestellingen = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Status vertaling
function statusTekst(int $status): string {
    return match ($status) {
        0 => 'Nieuw',
        1 => 'In de oven',
        2 => 'Onderweg',
        3 => 'Afgeleverd',
        default => 'Onbekend'
    };
}
?>

<h1>Mijn bestellingen</h1>

<?php if (empty($bestellingen)): ?>
    <p>Je hebt nog geen bestellingen geplaatst.</p>
<?php else: ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>Bestelnummer</th>
            <th>Datum</th>
            <th>Adres</th>
            <th>Status</th>
        </tr>

        <?php foreach ($bestellingen as $b): ?>
            <tr>
                <td><?= htmlspecialchars($b['order_id']) ?></td>
                <td><?= htmlspecialchars($b['datetime']) ?></td>
                <td><?= htmlspecialchars($b['address']) ?></td>
                <td><?= statusTekst((int)$b['status']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php
require_once '../includes/footer.php';
