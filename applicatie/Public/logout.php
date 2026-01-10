<?php
// Session wordt gestart in header.php, maar hier starten we hem veilig zelf
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Alle sessievariabelen leegmaken
$_SESSION = [];

// Sessie vernietigen
session_destroy();

// Optioneel: sessie-cookie verwijderen (extra netjes)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Terug naar loginpagina
header('Location: login.php');
exit;
