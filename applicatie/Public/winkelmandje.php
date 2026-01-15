<?php
require_once '../includes/db_connectie.php';
require_once '../includes/header.php';

$db = maakVerbinding();

if (isset($_POST['aantal']) && is_array($_POST['aantal'])) {
    foreach ($_POST['aantal'] as $product => $aantal) {
        $aantal = (int)$aantal;

    if ($aantal < 0) {
        $aantal = 0;
    }

    if ($aantal > 5) {
        $aantal = 5;
    }

    if ($aantal > 0) {
        $_SESSION['winkelmandje'][$product] = $aantal;
    }
    }
}

if (isset($_POST['verwijder_product'])) {
    $productNaam = $_POST['verwijder_product'];

    if (isset($_SESSION['winkelmandje'][$productNaam])) {
        unset($_SESSION['winkelmandje'][$productNaam]);
    }
}

if (isset($_POST['leeg_winkelmandje'])) {
    unset($_SESSION['winkelmandje']);
}

$adres = '';

if (isset($_SESSION['username'])) {
    $sql = 'SELECT address FROM [User] WHERE username = :username';
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':username' => $_SESSION['username']
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && !empty($user['address'])) {
        $adres = $user['address'];
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
            <th>Actie</th>
        </tr>

        <?php foreach ($_SESSION['winkelmandje'] as $product => $aantal): ?>
            <tr>
                <td><?= htmlspecialchars($product) ?></td>
                <td><?= (int)$aantal ?></td>
                <td>
                    <form method="post" style="display:inline">
                        <button
                            type="submit"
                            name="verwijder_product"
                            value="<?= htmlspecialchars($product) ?>"
                            title="Verwijder product"
                        >
                            X
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>

    <form method="post">
        <button type="submit" name="leeg_winkelmandje">
            Leeg winkelmandje
        </button>
    </form>


    <form method="post" action="bestellen.php">
        <label for="adres">Afleveradres:</label><br>
        <input
            type="text"
            name="adres"
            id="adres"
            value="<?= htmlspecialchars($adres) ?>"
            required
            style="width:300px;"
        >
        <br><br>

        <button type="submit">Bestelling plaatsen</button>
    </form>

<?php endif; ?>

<?php
require_once '../includes/footer.php';
