<?php
require_once 'bootstrap/init.php';
//session_start();
//unset($_SESSION['id']);

// Borramos la cookie con el token.
setcookie('token', null, time() - 3600 * 24);

echo json_encode([
    'success' => true,
]);
