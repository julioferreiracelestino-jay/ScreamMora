<?php

class bd {
    //host
    private $host = "localhost";
    //usuario
    private $usuario = "root";
    //senha
    private $senha = "";
    //banco de dados
    private $banco = "streamora";
    public $conexao;

    public function conecta_mysql() {
        // Conectar usando MySQLi
        $this->conexao = new mysqli($this->host, $this->usuario, $this->senha, $this->banco);

        // Verificar se houve erro na conexão
        if ($this->conexao->connect_error) {
            die("Falha na conexão: " . $this->conexao->connect_error);
        }

        // Definir o charset para UTF-8
        $this->conexao->set_charset("utf8");

        return $this->conexao;
    }
}


?>




