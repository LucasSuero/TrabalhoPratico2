<?php include __DIR__ . '/../../views/includes/header.php';?>

<nav>
<!--Oh, dentro dessa nav, a minha ideia era pegar tipo, umas 8 categorias de dentro do 
banco de dados, tipo, de forma aleatória e colocar ali, por que assim é possível adicionar
infinitas categorias pro banco de dados e mesmo assim não vai quebrar o programa, cada uma 
dessas categorias levaria pra uma tabela com os jogos que tem essa categoria.-->

</nav>

<!--Pro restante da página a ideia é colocar um display de jogos igual a bibilioteca 
da epic games, tipo pra parecer uma loja mesmo. Pra fazer isso a gente ia precisar mexer 
na aba de produtos, que tem que ter uma entrada para imagem no formulário e no banco de dados
também, por que ele tem que ter uma forma de armazenar imagens, se o chatgpt não souber ajudar
o flores deve saber. E quando forem decorar essa pagína, eu acho uma ideia boa criar outro arquivo
css e aí vocês adicionam o link do arquivo header.php, igual tá ali os outros css, vai funcionar
normal
-->
    <?php 
include_once __DIR__ . '/../../controllers/ProdutoController.php';

$controller = new ProdutoController();
$produtosArray = $controller->index(); // retorna ['stmt' => ..., 'num' => ...]
$produtos = $produtosArray['stmt']; // aqui pegamos o PDOStatement
?>
<div class="produto">
    <?php while($produto = $produtos->fetch(PDO::FETCH_ASSOC)) : ?>
    
        <?php if(!empty($produto['imagem'])): ?>
            <img src="/crud_php/<?php echo $produto['imagem']; ?>" alt="<?php echo htmlspecialchars($produto['nome']);
             ?>" width="200px" >
        <?php endif; ?>
    
<?php endwhile; ?>
</div>

 <?php  include __DIR__ . '/../../views/includes/footer.php';?>