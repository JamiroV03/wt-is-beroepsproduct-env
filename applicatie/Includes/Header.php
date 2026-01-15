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
   <div class="topbar">
    <div class="user-info">
        <?php if (isset($_SESSION['username'])): ?>
            Ingelogd als:
            <a href="<?= $_SESSION['role'] === 'klant' ? 'profiel.php' : '#' ?>">
                <?= htmlspecialchars($_SESSION['username']) ?>
            </a>
            (<?= htmlspecialchars($_SESSION['role']) ?>)
        <?php else: ?>
            Niet ingelogd
        <?php endif; ?>
    </div>
</div>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="menu.php">Menu</a></li>

        <?php if (isset($_SESSION['username'])): ?>

            <?php if ($_SESSION['role'] === 'klant'): ?>
                <li><a href="profiel.php">Profiel</a></li>
                <li><a href="winkelmandje.php">Winkelmandje</a></li>
            <?php endif; ?>

            <?php if ($_SESSION['role'] === 'medewerker'): ?>
                <li><a href="overzicht.php">Overzicht</a></li>
            <?php endif; ?>

            

        <?php else: ?>
            <li><a href="login.php">Inloggen</a></li>
            <li><a href="registratie.php">Registreren</a></li>
        <?php endif; ?>
    </ul>
</nav>


</header>
<main>
