<?php
include_once __DIR__ . '/../../controllers/ProdutoController.php';
/******************************************************************************
Curso: Engenharia de Software
Disciplina: Linguagem e Técnicas de Programacão
Professor: José Carlos Domingues Flôres
Turma: ESOFT-2A
Componentes:
 25185655-2 - Leonardo Kenji Tanida Soares
 25125961-2 - Elias Borgers Neckel
 25011023-2 - Lucas Coelho Suero 
Data: 10 de novembro de 2025
*******************************************************************************/

$controller = new ProdutoController();
$categorias_stmt = $controller->getCategorias();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];
    $imagem = $_POST['imagem'];

    if ($controller->create($nome, $descricao, $preco, $categoria_id, $imagem)) {
        header('Location: /crud_php/public/index.php?page=produtos');
        exit();
    } else {
        echo "<p class='error'>Não foi possível criar o produto.</p>";
    }
}

include __DIR__ . '/../../views/includes/header.php';
?>

<h2 class="textoAba">Adicionar Jogo</h2>

<form action="/crud_php/public/index.php?page=produtos&action=create" method="POST" enctype="multipart/form-data">
    <label for="nome">Nome do jogo:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao"></textarea>

    <label for="preco">Preço:</label>
    <input type="number" id="preco" name="preco" step="0.01" required>

    <label for="categoria_id">Categoria:</label>
    <select id="categoria_id" name="categoria_id" required>
        <?php
        while ($categoria = $categorias_stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value=\"" . $categoria['id'] . "\">" . $categoria['nome'] . "</option>";
        }
        ?>
    </select>
    
    <label for="imagem">Imagem de capa</label>
    <input type="file" id="imagem" name="imagem" accept="image/*" required>

    <div class="botao">     <div class="direita">
    <button type="submit" class="button">Salvar</button>
    <a href="/crud_php/public/index.php?page=produtos" class="button">Cancelar</a>
    </div>
    </div>
    </div>
</form>

<?php include __DIR__ . '/../../views/includes/footer.php'; ?>
