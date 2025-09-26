<?php
session_start();
require_once('bd.class.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../admin.html");
    exit();
}

$response = ['success' => false, 'message' => ''];

try {
    // Validação
    if (empty($_POST['email']) || empty($_POST['senha'])) {
        throw new Exception("E-mail e senha são obrigatórios");
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    // Conexão com o banco
    $objBD = new bd();
    $conexao = $objBD->conecta_mysql();

    // Verifica se é admin (você pode ter uma tabela de administradores separada)
    $sql = "SELECT id, senha FROM usuarios WHERE email = ? AND admin = 1";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        throw new Exception("Credenciais inválidas ou acesso não autorizado");
    }

    $stmt->bind_result($id, $senha_hash);
    $stmt->fetch();

    if (!password_verify($senha, $senha_hash)) {
        throw new Exception("Credenciais inválidas");
    }

    // Configura a sessão
// Após verificar as credenciais com sucesso:
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_id'] = $id;
$_SESSION['admin_name'] = "Administrador"; // Ou pegue do banco
$_SESSION['admin_email'] = $email;
$_SESSION['last_activity'] = time();

    $response = [
        'success' => true,
        'message' => 'Login bem-sucedido',
        'redirect' => 'dashboard.html'
    ];

    $stmt->close();
    $conexao->close();

} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
?>