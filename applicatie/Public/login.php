<?php
session_start();
require_once '../includes/db_connectie.php';

$melding = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $melding = 'Vul alle velden in.';
    } else {
        $db = maakVerbinding();

        $sql = 'SELECT username, password, role FROM [User] WHERE username = :username';
        $stmt = $db->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header('Location: index.php');
            exit;
        } else {
            $melding = 'Ongeldige gebruikersnaam of wachtwoord.';
        }
    }
}

require_once '../includes/header.php';
?>

<h1>Inloggen</h1>

<?php if ($melding): ?>
    <p><?= htmlspecialchars($melding) ?></p>
<?php endif; ?>

<form method="post">
    <label>
        Gebruikersnaam:
        <input type="text" name="username" required>
    </label><br><br>

    <label>
        Wachtwoord:
        <input type="password" name="password" required>
    </label><br><br>

    <button type="submit">Inloggen</button>
</form>

<?php
require_once '../includes/footer.php';
