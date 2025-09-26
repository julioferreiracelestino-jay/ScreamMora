<?php
// Configurações de segurança da sessão
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Use apenas com HTTPS
ini_set('session.use_strict_mode', 1);

session_start();
require_once('bd.class.php');

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método não permitido");
    }

    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $input = $_POST;
    }

    if (empty($input['email']) || empty($input['senha'])) {
        throw new Exception("E-mail e senha são obrigatórios");
    }

    $email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
    $senha = $input['senha'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("E-mail inválido");
    }

    $objBD = new bd();
    $conexao = $objBD->conecta_mysql();

    // ATUALIZADO: Inclui a coluna admin na consulta
    $sql = "SELECT id, nomeCompleto, email, senha, foto_perfil, admin FROM usuarios WHERE email = ? LIMIT 1";
    $stmt = $conexao->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    $stmt->bind_param("s", $email);
    if (!$stmt->execute()) {
        throw new Exception("Erro ao executar a consulta: " . $stmt->error);
    }
    
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        throw new Exception("Credenciais inválidas");
    }

    $stmt->bind_result($id, $nome, $db_email, $senha_hash, $foto, $is_admin);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($senha, $senha_hash)) {
        throw new Exception("Credenciais inválidas");
    }

    session_regenerate_id(true);
    $_SESSION['id_usuario'] = $id;
    $_SESSION['usuario'] = $nome;
    $_SESSION['email'] = $db_email;
    $_SESSION['foto_perfil'] = $foto ?: 'img/perfil.png';
    $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    $_SESSION['last_activity'] = time();
    $_SESSION['is_admin'] = (bool)$is_admin; // Converte para boolean

    $response = [
        'success' => true,
        'message' => 'Login bem-sucedido',
        'user' => [
            'id' => $id,
            'name' => $nome,
            'email' => $db_email,
            'photo' => $_SESSION['foto_perfil'],
            'isAdmin' => $_SESSION['is_admin'] // Retorna o status de admin
        ],
        'redirect' => $_SESSION['is_admin'] ? 'adminPage.php' : 'index.php'
    ];

} catch (Exception $e) {
    http_response_code(400);
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
    error_log('Erro no login: ' . $e->getMessage());
}

echo json_encode($response);
exit;
?>