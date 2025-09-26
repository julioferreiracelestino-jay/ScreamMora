<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    die(json_encode(['error' => 'Não autorizado']));
}

echo json_encode([
    'name' => $_SESSION['admin_name'] ?? 'Administrador',
    'email' => $_SESSION['admin_email'] ?? 'admin@streamora.com',
    'photo' => 'img/perfil.png' // Ou caminho da foto do admin se tiver
]);
?>