<?php
session_start();
header('Content-Type: application/json');

$response = [
    'isAdmin' => false,
    'user' => null
];

try {
    // Verifica se o admin está logado
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        $response['isAdmin'] = true;
        $response['user'] = [
            'name' => $_SESSION['admin_name'] ?? 'Administrador',
            'email' => $_SESSION['admin_email'] ?? 'admin@streamora.com'
        ];
    }
} catch (Exception $e) {
    // Pode adicionar logging de erro se necessário
}

echo json_encode($response);
?>