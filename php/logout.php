<?php
session_start();

// Limpa todos os dados da sessão
$_SESSION = array();

// Se deseja destruir o cookie de sessão
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrói a sessão
session_destroy();

header('Content-Type: application/json');
echo json_encode(['success' => true]);
exit;
?>