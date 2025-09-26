<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
ob_start();

define('DEBUG_MODE', true);

session_start();
require_once('bd.class.php');

try {
    if (!isset($_SESSION['is_admin'])) {
        http_response_code(403);
        throw new Exception("Acesso negado: Faça login como administrador");
    }

    $objBD = new bd();
    $conexao = $objBD->conecta_mysql();

    // Consulta modificada para excluir administradores
    $sql = "SELECT 
                id, 
                nomeCompleto as nome, 
                email, 
                DATE_FORMAT(data_cadastro, '%d/%m/%Y') as data_cadastro,
                foto_perfil as foto,
                'Ativo' as status,
                'Recentemente' as ultimo_acesso
            FROM usuarios
            WHERE admin = 0  
            ORDER BY data_cadastro DESC 
            LIMIT 100";

    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        throw new Exception("Erro ao preparar consulta: " . $conexao->error);
    }

    if (!$stmt->execute()) {
        throw new Exception("Erro ao executar consulta: " . $stmt->error);
    }

    $resultado = $stmt->get_result();
    $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);

    foreach ($usuarios as &$usuario) {
        $usuario['foto'] = $usuario['foto'] ?: 'img/perfil.png';
    }

    ob_end_clean();
    echo json_encode($usuarios);
    exit();

} catch (Exception $e) {
    ob_end_clean();
    http_response_code(500);
    $response = ['error' => $e->getMessage()];
    
    if (DEBUG_MODE) {
        $response['trace'] = $e->getTrace();
    }
    
    echo json_encode($response);
    exit();
}
?>