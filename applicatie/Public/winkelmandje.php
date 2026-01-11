<?php
require_once '../includes/db_connectie.php';
require_once '../includes/header.php';

if (!isset($_SESSION['winkelmandje'])) {
    $_SESSION['winkelmandje'] = [];
}

// Verwerken van formulier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aantal']) && is_array($_POST['aantal'])) {

    foreach ($_POST['aantal'] as $productNaam => $aantal) {
        $aantal = (int)$aantal;

        if ($aantal > 0) {
            if (isset($_SESSION['winkelmandje'][$productNaam])) {
                $_SESSION['winkelmandje'][$productNaam] += $aantal;
            } else {
                $_SESSION['winkelmandje'][$productNaam] = $aantal;
            }
        }
    }
}
?>

<h1>Winkelmandje</h1>

<?php if (empty($_SESSION['winkelmandje'])): ?>
    <p>Je winkelmandje is leeg.</p>
<?php else: ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>Product</th>
            <th>Aantal</th>
        </tr>

        <?php foreach ($_SESSION['winkelmandje'] as $product => $aantal): ?>
            <tr>
                <td><?= htmlspecialchars($product) ?></td>
                <td><?= (int)$aantal ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>

    <form method="post" action="bestellen.php">
        <label for="adres">Afleveradres:</label><br>
        <input type="text" name="adres" id="adres" required><br><br>

        <button type="submit">Bestelling plaatsen</button>
    </form>
<?php endif; ?>

<?php
require_once '../includes/footer.php';
