<?php
include_once '../config/database.php';
include_once '../models/Produto.php';
include_once '../models/Categoria.php';

class ProdutoController {
    private $conn;
    private $produto;
    private $categoria;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->produto = new Produto($this->conn);
        $this->categoria = new Categoria($this->conn);
    }

    public function index() {
        $sql = "
            SELECT j.id,
                   j.nome,
                   j.descricao,
                   j.preco,
                   j.imagem,
                   j.categoria_id,
                   c.nome AS categoria_nome
            FROM jogos j
            LEFT JOIN categorias c ON j.categoria_id = c.id
            ORDER BY j.id DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return ['stmt' => $stmt, 'num' => $stmt->rowCount()];
    }

    // --- CREATE PRODUCT ---
    public function create($nome, $descricao, $preco, $categoria_id) {
        $caminhoBanco = null;

        // Handle file upload
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $pasta = __DIR__ . '/../public/uploads/'; // Ensure this folder exists
            if (!is_dir($pasta)) mkdir($pasta, 0777, true);

            $nomeArquivo = uniqid() . '-' . basename($_FILES['imagem']['name']);
            $caminhoDestino = $pasta . $nomeArquivo;

            if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
                echo "<p class='error'>Erro ao mover o arquivo de imagem. Verifique permissões da pasta uploads/</p>";
                return false;
            }

            $caminhoBanco = 'uploads/' . $nomeArquivo; // relative path for DB
        } else {
            echo "<p class='error'>Nenhuma imagem enviada ou erro no upload.</p>";
            return false;
        }

        // Save to database
        $this->produto->nome = $nome;
        $this->produto->descricao = $descricao;
        $this->produto->preco = $preco;
        $this->produto->categoria_id = $categoria_id;
        $this->produto->imagem = $caminhoBanco;

        return $this->produto->create();
    }

    // --- UPDATE PRODUCT ---
    public function update($id, $nome, $descricao, $preco, $categoria_id) {
        $caminhoBanco = null;

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $pasta = __DIR__ . '/../public/uploads/';
            if (!is_dir($pasta)) mkdir($pasta, 0777, true);

            $nomeArquivo = uniqid() . '-' . basename($_FILES['imagem']['name']);
            $caminhoDestino = $pasta . $nomeArquivo;

            if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
                echo "<p class='error'>Erro ao mover o arquivo de imagem.</p>";
                return false;
            }

            $caminhoBanco = 'uploads/' . $nomeArquivo;
        }

        $this->produto->id = $id;
        $this->produto->nome = $nome;
        $this->produto->descricao = $descricao;
        $this->produto->preco = $preco;
        $this->produto->categoria_id = $categoria_id;

        // Update image only if a new one was uploaded
        if ($caminhoBanco) $this->produto->imagem = $caminhoBanco;

        return $this->produto->update();
    }

    public function readOne($id) {
        $this->produto->id = $id;
        $this->produto->readOne();
        return $this->produto;
    }

    public function delete($id) {
        $this->produto->id = $id;
        return $this->produto->delete();
    }

    public function getCategorias() {
        return $this->categoria->read();
    }
}
?>
