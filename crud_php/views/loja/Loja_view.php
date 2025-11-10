<?php include __DIR__ . '/../../views/includes/header.php';
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
*******************************************************************************/?>

<nav>


</nav>

    <?php 
include_once __DIR__ . '/../../controllers/ProdutoController.php';

$controller = new ProdutoController();
$produtosArray = $controller->index(); // retorna ['stmt' => ..., 'num' => ...]
$produtos = $produtosArray['stmt']; // aqui pegamos o PDOStatement
?>

<div class="produto">
    <?php while($produto = $produtos->fetch(PDO::FETCH_ASSOC)) : ?>
    
        <?php if(!empty($produto['imagem'])): ?>
            <div class="produto-item">
            <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo htmlspecialchars($produto['nome']);
             ?>" >
        <?php endif; ?>
    <div class="overlay">
          <h3 class="nome"><?php echo htmlspecialchars($produto['nome']); ?></h3>
          <p class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
          <p class="cat">Categoria: <?php echo htmlspecialchars($produto['categoria_nome']); ?></p>
          <p class="desc"><?php echo htmlspecialchars($produto['descricao']); ?></p>
        </div>
    </div>
<?php endwhile; ?>
</div>


 <?php  include __DIR__ . '/../../views/includes/footer.php';?>
