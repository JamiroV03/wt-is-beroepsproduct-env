<?php
require_once '../includes/db_connectie.php';
require_once '../includes/header.php';

$melding = '';
$fouten = [];

// Default waarden (blijven staan bij fouten)
$username = '';
$first_name = '';
$last_name = '';
$address = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $db = maakVerbinding();

    // Invoer ophalen
    $username   = trim($_POST['username'] ?? '');
    $password   = $_POST['password'] ?? '';
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $address    = trim($_POST['address'] ?? '');
    $role       = 'klant';

    // Validatie
    if ($username === '') {
        $fouten[] = 'Gebruikersnaam is verplicht.';
    }

    if ($first_name === '') {
        $fouten[] = 'Voornaam is verplicht.';
    }

    if ($last_name === '') {
        $fouten[] = 'Achternaam is verplicht.';
    }

    // Wachtwoord eisen
    if (
        strlen($password) < 8 ||
        !preg_match('/[0-9]/', $password) ||
        !preg_match('/[^a-zA-Z0-9]/', $password)
    ) {
        $fouten[] = 'Wachtwoord moet minimaal 8 tekens bevatten, met een cijfer en een speciaal teken.';
    }

    // Als geen fouten → opslaan
    if (empty($fouten)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO [User] 
                (username, password, first_name, last_name, address, role)
                VALUES (?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([
                $username,
                $hashedPassword,
                $first_name,
                $last_name,
                $address,
                $role
            ]);

            $melding = 'Registratie gelukt! Je kunt nu inloggen.';

            // Formulier leegmaken na succes
            $username = $first_name = $last_name = $address = '';

        } catch (PDOException $e) {
            $fouten[] = 'Gebruikersnaam bestaat al.';
        }
    }
}
?>

<h1>Registreren</h1>

<?php if (!empty($fouten)): ?>
    <ul style="color:red;">
        <?php foreach ($fouten as $fout): ?>
            <li><?= htmlspecialchars($fout) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($melding): ?>
    <p style="color:green;"><?= htmlspecialchars($melding) ?></p>
<?php endif; ?>

<form method="post">
    <label>Gebruikersnaam</label><br>
    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" required><br><br>

    <label>Wachtwoord</label><br>
    <input type="password" name="password" required>
    <p style="font-size:0.9em; color:#555;">
        Minimaal 8 tekens, 1 cijfer en 1 speciaal teken.
    </p><br>

    <label>Voornaam</label><br>
    <input type="text" name="first_name" value="<?= htmlspecialchars($first_name) ?>" required><br><br>

    <label>Achternaam</label><br>
    <input type="text" name="last_name" value="<?= htmlspecialchars($last_name) ?>" required><br><br>

    <label>Adres</label><br>
    <input type="text" name="address" value="<?= htmlspecialchars($address) ?>"><br><br>

    <button type="submit">Registreren</button>
</form>

<?php
require_once '../includes/footer.php';
?>
