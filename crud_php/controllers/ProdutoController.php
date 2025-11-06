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
        $num = $stmt->rowCount();
        return ['stmt' => $stmt, 'num' => $num];
    }

    public function create($nome, $descricao, $preco, $categoria_id) {
        $caminhoBanco = null; // Caminho a ser salvo no banco

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $pasta = __DIR__ . '/../uploads/';
            if (!is_dir($pasta)) {
                mkdir($pasta, 0777, true);
            }

            // Gera um nome único para evitar conflitos
            $nomeArquivo = uniqid() . '-' . basename($_FILES['imagem']['name']);
            $caminhoDestino = $pasta . $nomeArquivo;

            // Move o arquivo enviado
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
                $caminhoBanco = 'uploads/' . $nomeArquivo;
            } else {
                echo "Erro ao mover o arquivo de imagem.";
                return false;
            }
        }
        $this->produto->nome = $nome;
        $this->produto->descricao = $descricao;
        $this->produto->preco = $preco;
        $this->produto->categoria_id = $categoria_id;
        $this->produto->imagem = $caminhoBanco;
        if($this->produto->create()) {
            return true;
        }
        return false;
    }

    public function readOne($id) {
        $this->produto->id = $id;
        $this->produto->readOne();
        return $this->produto;
    }

    public function update($id, $nome, $descricao, $preco, $categoria_id) {
        $caminhoBanco = null; // Caminho a ser salvo no banco

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $pasta = __DIR__ . '/../uploads/';
            if (!is_dir($pasta)) {
                mkdir($pasta, 0777, true);
            }

            // Gera um nome único para evitar conflitos
            $nomeArquivo = uniqid() . '-' . basename($_FILES['imagem']['name']);
            $caminhoDestino = $pasta . $nomeArquivo;

            // Move o arquivo enviado
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
                $caminhoBanco = 'uploads/' . $nomeArquivo;
            } else {
                echo "Erro ao mover o arquivo de imagem.";
                return false;
            }
        }
        $this->produto->id = $id;
        $this->produto->nome = $nome;
        $this->produto->descricao = $descricao;
        $this->produto->preco = $preco;
        $this->produto->categoria_id = $categoria_id;
        $this->produto->imagem = $caminhoBanco;
        if($this->produto->update()) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        $this->produto->id = $id;
        if($this->produto->delete()) {
            return true;
        }
        return false;
    }

    public function getCategorias() {
        $stmt = $this->categoria->read();
        return $stmt;
    }
}
?>
