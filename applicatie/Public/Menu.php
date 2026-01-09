<?php
require_once '../includes/db_connectie.php';

$db = maakVerbinding();

$sql = "
    SELECT 
        p.name,
        p.price,
        pt.name AS type
    FROM Product p
    JOIN ProductType pt ON p.type_id = pt.name
    ORDER BY pt.name, p.name
";

$stmt = $db->query($sql);
$producten = $stmt->fetchAll();

require_once '../includes/header.php';
?>


<h1>Menu</h1>


<form method="post" action="winkelmandje.php">
    <table border="1" cellpadding="5">
        <tr>
            <th>Product</th>
            <th>Type</th>
            <th>Prijs</th>
            <th>Aantal</th>
        </tr>

        <?php foreach ($producten as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['type']) ?></td>
                <td>€<?= number_format($product['price'], 2, ',', '.') ?></td>
                <td>
<input 
    type="number"
    name="aantal[<?= htmlspecialchars($product['name']) ?>]"
    value="0"
    min="0"
>

            </tr>
        <?php endforeach; ?>

    </table>

    <br>
    <button type="submit">Toevoegen aan winkelmandje</button>
</form>

<?php
require_once '../includes/footer.php';
