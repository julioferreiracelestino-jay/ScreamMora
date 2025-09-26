<?php
session_start();
require_once('bd.class.php');

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../index.html");
    exit();
}

// Configurações
$max_file_size = 2 * 1024 * 1024; // 2MB
$allowed_types = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
$upload_dir = __DIR__ . '/../uploads/profiles/'; // Caminho absoluto

// Inicializa resposta JSON
$response = ['success' => false, 'message' => ''];

try {
    // Validação dos campos obrigatórios
    $required_fields = ['nomeCompleto', 'email', 'senha', 'data_nascimento'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("O campo " . ucfirst($field) . " é obrigatório.");
        }
    }

    // Sanitização dos dados
    $nome = filter_input(INPUT_POST, 'nomeCompleto', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];
    $data_nascimento = $_POST['data_nascimento'];

    // Validação de e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("E-mail inválido.");
    }

    // Processamento da foto de perfil
    $foto_perfil = null;
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['profilePicture'];

        // Verificação de segurança adicional
        if (!is_uploaded_file($foto['tmp_name'])) {
            throw new Exception("Possível ataque de upload de arquivo.");
        }

        // Verificação do tipo de arquivo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $foto['tmp_name']);
        finfo_close($finfo);

        if (!array_key_exists($mime_type, $allowed_types)) {
            throw new Exception("Tipo de arquivo não permitido. Use apenas JPEG, PNG ou GIF.");
        }

        // Verificação do tamanho do arquivo
        if ($foto['size'] > $max_file_size) {
            throw new Exception("O arquivo é muito grande. O tamanho máximo permitido é 2MB.");
        }

        // Cria diretório se não existir - MODIFICADO
        if (!file_exists($upload_dir)) {
            if (!mkdir($upload_dir, 0755, true)) {
                throw new Exception("Não foi possível criar o diretório para upload.");
            }
        }

        // Gera nome único e move o arquivo - MODIFICADO
        $ext = $allowed_types[$mime_type];
        $filename = uniqid() . '.' . $ext;
        $destination = $upload_dir . $filename;

        // Sanitiza o nome do arquivo
        $destination = str_replace(['../', '..\\'], '', $destination);

        if (!move_uploaded_file($foto['tmp_name'], $destination)) {
            throw new Exception("Falha ao salvar a imagem de perfil.");
        }

        // Armazena caminho relativo para o banco - MODIFICADO
        $foto_perfil = 'uploads/profiles/' . $filename;
    }
    // Conexão com o banco de dados
    $objBD = new bd();
    $conexao = $objBD->conecta_mysql();

    // Verifica se o e-mail já existe
    $sql_verifica = "SELECT id FROM usuarios WHERE email = ?";
    $stmt_verifica = $conexao->prepare($sql_verifica);
    $stmt_verifica->bind_param("s", $email);
    $stmt_verifica->execute();
    $stmt_verifica->store_result();
    
    if ($stmt_verifica->num_rows > 0) {
        throw new Exception("Este e-mail já está cadastrado.");
    }
    $stmt_verifica->close();

    // Hash da senha
    $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

    // Insere o novo usuário
    $sql = "INSERT INTO usuarios(nomeCompleto, email, senha, data_nascimento, foto_perfil) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssss", $nome, $email, $senha_hashed, $data_nascimento, $foto_perfil);

    if (!$stmt->execute()) {
        throw new Exception("Erro ao registrar o usuário no banco de dados.");
    }

    // Configura a sessão
    $_SESSION['usuario'] = $nome;
    $_SESSION['email'] = $email;
    $_SESSION['id_usuario'] = $conexao->insert_id;

    // Resposta de sucesso
    $response = [
        'success' => true,
        'message' => 'Cadastro realizado com sucesso!',
        'redirect' => 'login.html',
        'user_id' => $conexao->insert_id
    ];

    $stmt->close();
    $conexao->close();

} catch (Exception $e) {
    // Remove a foto se foi salva mas ocorreu outro erro
    if (isset($destination) && file_exists($destination)) {
        unlink($destination);
    }

    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
}

// Retorna resposta JSON
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
