<?php
session_start();
 if (isset($_SESSION['username'])):
?>
    <li><a href="logout.php">Uitloggen</a></li>
<?php endif; ?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Pizzeria Sole Machina</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header>
    <div style="float: right; font-size: 0.9em;">
    <?php if (isset($_SESSION['username'])): ?>
        👤 Ingelogd als:
        <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
        (<?= htmlspecialchars($_SESSION['role']) ?>)
    <?php else: ?>
        Niet ingelogd
    <?php endif; ?>
</div>
    <nav>
        <a href="index.php">Home</a> |
        <a href="menu.php">Menu</a> |
        <a href="login.php">Login</a> |
        <a href="registratie.php">Registreren</a>
    </nav>
</header>
<main>
