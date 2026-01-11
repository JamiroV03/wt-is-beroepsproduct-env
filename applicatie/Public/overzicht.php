<?php
require_once '../includes/db_connectie.php';
require_once '../includes/header.php';

// Alleen personeel
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'medewerker') {
    header('Location: login.php');
    exit;
}

$db = maakVerbinding();

/* -------------------------
   Status aanpassen
-------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $stmt = $db->prepare("
        UPDATE Pizza_Order
        SET status = ?
        WHERE order_id = ?
    ");
    $stmt->execute([
        (int)$_POST['status'],
        (int)$_POST['order_id']
    ]);
}

/* -------------------------
   Filtering
-------------------------- */
$statusFilter = $_GET['status'] ?? 'all';

$sql = "
    SELECT order_id, client_username, client_name, datetime, status, address
    FROM Pizza_Order
";

$params = [];

if ($statusFilter !== 'all') {
    $sql .= " WHERE status = ?";
    $params[] = (int)$statusFilter;
}

$sql .= " ORDER BY datetime DESC";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$bestellingen = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Status labels
$statusLabels = [
    0 => 'Nieuw',
    1 => 'In de oven',
    2 => 'Onderweg',
    3 => 'Afgeleverd'
];
?>

<h1>Bestellingoverzicht (Personeel)</h1>

<form method="get">
    <label for="status">Filter op status:</label>
    <select name="status" id="status">
        <option value="all">Alle</option>
        <?php foreach ($statusLabels as $k => $v): ?>
            <option value="<?= $k ?>" <?= $statusFilter == $k ? 'selected' : '' ?>>
                <?= $v ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filter</button>
</form>

<br>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Klant</th>
        <th>Adres</th>
        <th>Datum</th>
        <th>Status</th>
        <th>Wijzig</th>
    </tr>

    <?php foreach ($bestellingen as $b): ?>
        <tr>
            <td><?= htmlspecialchars($b['order_id']) ?></td>
            <td><?= htmlspecialchars($b['client_name']) ?></td>
            <td><?= htmlspecialchars($b['address']) ?></td>
            <td><?= htmlspecialchars($b['datetime']) ?></td>
            <td><?= $statusLabels[$b['status']] ?? 'Onbekend' ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="order_id" value="<?= $b['order_id'] ?>">
                    <select name="status">
                        <?php foreach ($statusLabels as $k => $v): ?>
                            <option value="<?= $k ?>" <?= $b['status'] == $k ? 'selected' : '' ?>>
                                <?= $v ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Opslaan</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php
require_once '../includes/footer.php';
