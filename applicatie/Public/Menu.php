<?php
require_once '../includes/db_connectie.php';
require_once '../includes/header.php';

$db = maakVerbinding();

// Bepaal loginstatus
$isIngelogd = isset($_SESSION['username']);
$isKlant = $isIngelogd && $_SESSION['role'] === 'klant';

// Producten ophalen
$stmt = $db->query("SELECT name, price FROM Product ORDER BY name");
$producten = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Menu</h1>

<?php if (!$isIngelogd): ?>
    <p><strong>Let op:</strong> Je moet ingelogd zijn om te kunnen bestellen.</p>
<?php elseif (!$isKlant): ?>
    <p><strong>Personeel kan geen bestellingen plaatsen.</strong></p>
<?php endif; ?>

<form method="post" action="winkelmandje.php">
    <table border="1" cellpadding="5">
        <tr>
            <th>Product</th>
            <th>Prijs</th>
            <th>Aantal</th>
        </tr>

        <?php foreach ($producten as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td>€<?= number_format($product['price'], 2, ',', '.') ?></td>
                <td>
                    <input
                        type="number"
                        name="aantal[<?= htmlspecialchars($product['name']) ?>]"
                        value="0"
                        min="0"
                        <?= !$isKlant ? 'disabled' : '' ?>
                    >
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>

    <button type="submit" <?= !$isKlant ? 'disabled' : '' ?>>
        Toevoegen aan winkelmandje
    </button>
</form>

<?php
require_once '../includes/footer.php';
