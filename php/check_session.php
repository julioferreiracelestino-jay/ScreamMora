<?php
session_start();
header('Content-Type: application/json');

$response = [
    'authenticated' => false,
    'user' => null
];

try {
    // Verificação robusta de sessão
    if (isset($_SESSION['id_usuario'])) {
        // Verificação de segurança adicional
        if ($_SESSION['user_ip'] === $_SERVER['REMOTE_ADDR'] && 
            $_SESSION['user_agent'] === $_SERVER['HTTP_USER_AGENT']) {
            
            $response = [
                'authenticated' => true,
                'user' => [
                    'id' => $_SESSION['id_usuario'],
                    'name' => $_SESSION['usuario'],
                    'email' => $_SESSION['email'],
                    'photo' => $_SESSION['foto_perfil'] ?? 'img/perfil.png',
                    'isAdmin' => $_SESSION['is_admin'] ?? false
                ]
            ];
        }
    }
} catch (Exception $e) {
    // Log do erro sem expor detalhes ao cliente
    error_log('Erro ao verificar sessão: ' . $e->getMessage());
}

echo json_encode($response);
?>