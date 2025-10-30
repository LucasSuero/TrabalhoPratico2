<?php
/*Esse arquivo em php serve somente para conectar na data base, como eu estava enfrentando problemas
ao trocar de maquinas constantemente para mexer no trabalho, notei que eu sempre tinha que manualmente
criar um banco de dados no phpmyadmin pra poder utilziar meu código, então eu entrei no chatgpt e 
perguntei se havia alguma forma de automatizar isso, por tanto, esse é o motivo da base do database.php
estar tão diferente.*/
class Database {
    private $host = "localhost";
    private $db_name = "gamesellingplat_db"; // nome do banco de dados
    private $username = "root";
    private $password = ""; // senha padrão do XAMPP
    public $conn;

    public function getConnection(){
        $this->conn = null;

        try {
            // Conecta ao MySQL sem especificar banco
            $this->conn = new PDO("mysql:host=" . $this->host, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Cria o banco se não existir
            $this->conn->exec("CREATE DATABASE IF NOT EXISTS " . $this->db_name . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            // Seleciona o banco
            $this->conn->exec("USE " . $this->db_name);

            // Cria tabelas se não existirem
            $this->conn->exec("
                CREATE TABLE IF NOT EXISTS categorias (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    nome VARCHAR(255) NOT NULL,
                    PRIMARY KEY(id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");

            $this->conn->exec("
                CREATE TABLE IF NOT EXISTS jogos (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    nome VARCHAR(255) NOT NULL,
                    descricao TEXT,
                    preco DECIMAL(10,2) NOT NULL,
                    categoria_id INT(11) NOT NULL,
                    PRIMARY KEY(id),
                    imagem VARCHAR(255),
                    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");

            // Define charset
            $this->conn->exec("SET NAMES utf8");

        } catch(PDOException $exception) {
            echo "Erro de conexão ou criação do banco/tabela: " . $exception->getMessage();
        }

        return $this->conn;
    }
}