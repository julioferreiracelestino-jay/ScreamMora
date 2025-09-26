<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

ob_start();
session_start();
require_once('bd.class.php');

// Verifica o método HTTP permitindo POST e DELETE também
if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST', 'DELETE'])) {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

try {
    // Verificação de sessão admin consistente
    if (!isset($_SESSION['is_admin'])) {
        http_response_code(403);
        throw new Exception("Acesso negado: Faça login como administrador");
    }

    // Obtém o ID do usuário a ser deletado
    $input = json_decode(file_get_contents('php://input'), true) ?: $_REQUEST;
    if (!isset($input['id']) || !ctype_digit($input['id'])) {
        throw new Exception("ID de usuário inválido");
    }

    $userId = (int)$input['id'];
    $currentUserId = (int)$_SESSION['id_usuario'];

    // Conexão com o banco
    $objBD = new bd();
    $conexao = $objBD->conecta_mysql();

    // Verifica se o usuário existe e se é admin
    $stmt = $conexao->prepare("SELECT id, admin FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($dbId, $isAdmin);
    $stmt->fetch();
    $stmt->close();

    if (!$dbId) {
        throw new Exception("Usuário não encontrado");
    }

    // Validações de segurança
    if ($isAdmin) {
        throw new Exception("Não é permitido deletar contas de administrador");
    }

    if ($userId === $currentUserId) {
        throw new Exception("Você não pode deletar sua própria conta");
    }

    // Executa a deleção
    $stmt = $conexao->prepare("DELETE FROM usuarios WHERE id = ? AND admin = 0");
    $stmt->bind_param("i", $userId);
    $success = $stmt->execute();

    if (!$success || $stmt->affected_rows === 0) {
        throw new Exception("Erro ao deletar usuário");
    }

    $response = [
        'success' => true,
        'message' => 'Usuário deletado com sucesso'
    ];

} catch (Exception $e) {
    http_response_code(500);
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conexao)) $conexao->close();
    
    ob_end_clean();
    echo json_encode($response);
    exit;
}
?>