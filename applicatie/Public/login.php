<?php
require_once '../includes/db_connectie.php';
require_once '../includes/header.php';

$melding = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $db = maakVerbinding();

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $melding = 'Vul alle velden in.';
    } else {

        $sql = "SELECT username, password, first_name, role
                FROM [User]
                WHERE username = ?";

        $stmt = $db->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['ingelogd'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['name']     = $user['first_name'];
            $_SESSION['role']     = $user['role'];

            if ($user['role'] === 'medewerker') {
                header('Location: overzicht.php');
            } else {
                header('Location: profiel.php');
            }
            exit;

        } else {
            $melding = 'Ongeldige gebruikersnaam of wachtwoord.';
        }
    }
}
?>

<h1>Inloggen</h1>

<?php if ($melding): ?>
    <p style="color:red;"><?= htmlspecialchars($melding) ?></p>
<?php endif; ?>

<form method="post">
    <label>Gebruikersnaam</label><br>
    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" required><br><br>

    <label>Wachtwoord</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Inloggen</button>
</form>

<p>
    Nog geen account?
    <a href="registratie.php">Registreer hier</a>
</p>

<?php
require_once '../includes/footer.php';
?>
