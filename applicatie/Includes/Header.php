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
    <nav>
        <a href="index.php">Home</a> |
        <a href="menu.php">Menu</a> |
        <a href="login.php">Login</a> |
        <a href="registratie.php">Registreren</a>
    </nav>
</header>
<main>
